<?php
namespace src\Presenter\Admin;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Constant\Template as T;
use src\Collection\Collection;
use src\Domain\Criteria\ITCharacterCriteria;
use src\Domain\Criteria\MonsterCriteria;
use src\Domain\Entity\InitiativeTracker;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Renderer\TemplateRenderer;
use src\Utils\Session;

final class InitiativeAdminPresenter
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function presentInitiativePanel(): string
    {
        $combatId = Session::fromGet('combatId');

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
                $this->buildITEnnemyAside(),
                !$partyMembers->isEmpty() ? 'has-combatants' : '',
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
            $listPartyMembers .= $this->serviceFactory->initTrackCharacter()->buildAsidePartyMember($partyMember);
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

    private function buildITEnnemyAside(): string
    {
        $monsterCriteria = new MonsterCriteria();
        $monsterCriteria->limit = -1;
        $monsters = $this->readerFactory->monster()->allMonsters($monsterCriteria);

        $content = '';
        foreach ($monsters as $monster) {
            $content .= $this->renderer->render(
                T::ADMIN_IT_ENNEMY_MEMBER,
                $monster->getITData()
            );
        }
        return $this->renderer->render(
            T::ADMIN_IT_ENNEMY_ASIDE,
            [
                $content,
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
}
