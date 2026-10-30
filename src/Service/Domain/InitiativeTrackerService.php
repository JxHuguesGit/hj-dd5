<?php

namespace src\Service\Domain;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Constant\Template as T;
use src\Domain\Criteria\ITCharacterCriteria;
use src\Domain\Entity\InitiativeTracker;
use src\Domain\Entity\ITCharacter;
use src\Renderer\TemplateRenderer;
use src\Service\Reader\InitTrackCharacterReader;

final class InitiativeTrackerService
{
    public function __construct(
        private InitTrackCharacterService $service,
        private TemplateRenderer $renderer,
    ) {}

    public function buildIdContentPanel(Collection $members, InitiativeTracker $initiativeTracker): string
    {
        $content = '';
        foreach ($members as $member) {
            if ($member->active == 0) {
                continue;
            }
            $content .= $this->buildCombatMember($member, $initiativeTracker->currentParticipantId == $member->id);
        }
        return $content;
    }

    public function buildCombatMember(ITCharacter $member, bool $active): string
    {
        $classMember  = $member->characterType == 'player' ? 'character' : $member->characterType;
        $classMember .= $active ? ' active' : '';
        $tmpHp = $member->tmpHp;

        $baseLength = $member->curHp / $member->maxHp;
        if ($tmpHp != 0) {
            $sum = $member->curHp + $tmpHp;
            $coloredLength = $member->curHp * $baseLength / $sum;
            $tmpHpLength = $tmpHp * $baseLength / $sum;
        } else {
            $coloredLength = $baseLength;
            $tmpHpLength = 0;
        }
        $baseRatio = $baseLength * 100;
        $coloredLength *= 100;
        $tmpHpLength *= 100;

        $colorCode = match (true) {
            $baseRatio === 100 => 'fullHealth',
            $baseRatio >= 80   => 'grazed',
            $baseRatio >= 50   => 'injured',
            $baseRatio >= 30   => 'bloodied',
            $baseRatio >= 10   => 'critical',
            $baseRatio > 0     => 'agonizing',
            default                => 'dying',
        };

        return $this->renderer->render(
            T::ADMIN_IT_CONTENT_PANEL,
            [
                $member->id,
                $classMember,
                $member->name,
                $member->maxHp,
                $member->ac,
                $member->initiative == null ? '-' : floor($member->initiative),
                $member->initiative == null ? '' : floor($member->initiative),
                $member->curHp,
                $coloredLength . '%',
                $tmpHpLength . '%',
                $colorCode,
                $this->buildCharacterStatus($member),
                '',
                $member->tmpHp == 0 ? B::DNONE : '',
                $member->tmpHp,
            ]
        );
    }

    private function buildCharacterStatus(ITCharacter $member): string
    {
        $isPlayer = $member->characterType == 'player';

        if ($isPlayer) {
            $heroicInspi = $member->heroicInspirationAvailable ? C::ACTIVE : '';
            $lair = B::DNONE;
        } else {
            $heroicInspi = B::DNONE;
            // TODO
            $lair = '';
        }

        return $this->renderer->render(
            T::ADMIN_IT_CBT_STATUS,
            [
                $lair,
                // Polymorph : tout le monde j'imagine. Mais pas encore géré
                B::DNONE,
                $member->reactionAvailable == 1 ? C::ACTIVE : '',
                $member->readyActive == 1 ? C::ACTIVE : '',
                $member->surprised == 1 ? C::ACTIVE : '',
                $heroicInspi,
                // Notes : tout le monde j'imagine, en valeur si une information est stockée. Mais pas encore géré
                B::DNONE,
                $isPlayer ? B::DNONE : '',
                $member->id,
            ]
        );
    }

    public function buildActiveCombatPanel(
        InitiativeTracker $initiativeTracker,
        InitTrackCharacterReader $itcReader,
    ): string {
        $criteria = new ITCharacterCriteria();
        $criteria->initiativeTrackerId = $initiativeTracker->id;
        $criteria->active = 1;
        $criteria->orderBy = [F::INITIATIVE => C::DESC];

        $members = $itcReader->allItCharacters($criteria);

        return $this->buildIdContentPanel($members, $initiativeTracker);
    }

    public function buildITPartyAside(Collection $partyMembers): string
    {
        $listPartyMembers = '';
        foreach ($partyMembers as $partyMember) {
            $listPartyMembers .= $this->service->buildAsidePartyMember($partyMember);
        }

        return $this->renderer->render(
            T::ADMIN_IT_PARTY_ASIDE,
            [
                // Si aucun personnage listé, on ne peut pas monter de niveau.
                $partyMembers->isEmpty() ? C::DISABLED : '',
                // Si aucun personnage listé, on affiche le message "Pas de participants".
                $partyMembers->isEmpty() ? '' : B::DNONE,
                // On affiche la liste des personnages listés
                $listPartyMembers,
            ]
        );
    }
}
