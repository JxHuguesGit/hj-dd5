<?php
namespace src\Presenter\Admin;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Constant\Icon as I;
use src\Constant\Template as T;
use src\Collection\Collection;
use src\Domain\Criteria\ITCharacterCriteria;
use src\Domain\Entity\InitiativeTracker;
use src\Domain\Entity\ITCharacter;
use src\Domain\Entity\Map;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\InitiativeTrackerService;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class InitiativeAdminPresenter
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function presentInitiativePanel(): string
    {
        $combatId = filter_input(
            INPUT_GET,
            'combatId',
        );

        $initiativeTracker = $this->readerFactory->initiativeTracker()->initiativeTrackerByCode($combatId);
        $criteria = new ITCharacterCriteria();
        $criteria->initiativeTrackerId = $initiativeTracker->id;
        $criteria->orderBy = [F::INITIATIVE => C::DESC];
        $allCombattants = $this->readerFactory->initTrackCharacter()->allItCharacters($criteria);
        $criteria->characterType = 'player';
        $criteria->orderBy = [F::NAME => C::ASC];
        $partyMembers = $this->readerFactory->initTrackCharacter()->allItCharacters($criteria);

        return $this->renderer->render(
            T::ADMININITIATIVEPANEL,
            [
                PLUGINS_DD5,
                date('YmdHis'),
                $this->buildITHeader($initiativeTracker),
                $this->buildITPartyAside($partyMembers),
                '',//$this->buildITEnnemyAside($initiativeTracker),
                // Présence de combattants ? Combat en cours ?
                !$partyMembers->isEmpty() ? 'has-combatants'/* active-combat'*/ : '',
                $this->buildITHeaderPanel($initiativeTracker),
                $this->serviceFactory->initiativeTracker()->buildIdContentPanel($allCombattants, $initiativeTracker),
                $initiativeTracker->active ? 'combat-in-progress' : '',
            ]
        );
    }

    private function buildITHeader(InitiativeTracker $initiativeTracker): string
    {
        return $this->renderer->render(
            T::ADMIN_IT_HEADER,
            [
                $initiativeTracker->name,
                $initiativeTracker->iTCode,
                date('H:i'),
            ]
        );
    }

    private function buildITPartyAside(Collection $partyMembers): string
    {
        $listPartyMembers = '';
        foreach ($partyMembers as $partyMember) {
            $listPartyMembers .= $this->buildITPartyMember($partyMember);
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

    private function buildITPartyMember(ITCharacter $partyMember): string
    {
        return $this->renderer->render(
            T::ADMIN_IT_PARTY_MEMBER,
            [
                $partyMember->name,
                $partyMember->getCharacterStats(),
                $partyMember->id,
                $partyMember->active == 1 ? '' : 'benched',
            ]
        );
    }

    private function buildITEnnemyAside(InitiativeTracker $initiativeTracker): string
    {
        return $this->renderer->render(
            T::ADMIN_IT_ENNEMY_ASIDE,
            [
                // On affiche la liste des ennemis disponibles
                '',
            ]
        );

    }

    private function buildITHeaderPanel(InitiativeTracker $initiativeTracker): string
    {
        return $this->renderer->render(
            T::ADMIN_IT_HEADER_PANEL,
            [
                // Numéro du round
                $initiativeTracker->round,
            ]
        );
    }

    private function buildIdContentPanel(Collection $members, InitiativeTracker $initiativeTracker): string
    {
        $content = '';
        foreach ($members as $member) {
            if ($member->active==0) {
                continue;
            }
            $content .= $this->buildCombatMember($member, $initiativeTracker->currentParticipantId==$member->id);
        }
        return $content;
    }

    private function buildCombatMember(ITCharacter $member, bool $active): string
    {
        $classMember  = $member->characterType == 'player' ? 'character' : $member->characterType;
        $classMember .= $active ? ' active' : '';
        
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
            ]
        );
    }

}
