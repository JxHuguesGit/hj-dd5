<?php

namespace src\Controller\Admin;

use src\Constant\Constant as C;
use src\Domain\Entity\InitiativeTracker;
use src\Factory\ReaderFactory;
use src\Page\PageForm;
use src\Page\PageList;
use src\Presenter\Admin\InitiativeAdminPresenter;
use src\Presenter\FormBuilder\InitiativeTrackerFormBuilder;
use src\Presenter\TableBuilder\InitiativeTrackerTableBuilder;
use src\Presenter\ToastBuilder;
use src\Renderer\TemplateRenderer;
use src\Service\Writer\InitiativeTrackerWriter;
use src\Utils\Session;

final class AdminTimelineContent implements AdminContentInterface
{
    private string $toastContent = '';

    public function __construct(
        private ?int $mapId,
        private ReaderFactory $readerFactory,
        private InitiativeTrackerWriter $itWriter,
        private InitiativeAdminPresenter $initiativeAdminPresenter,
        private InitiativeTrackerFormBuilder $iTFormBuilder,
        private ToastBuilder $toastBuilder,
        private TemplateRenderer $templateRenderer
    ) {}

    public function getContent(): string
    {
        if (null === $this->mapId) {
            return $this->getCombatAdministration();
        }

        return $this->getTimelineContent();
    }

    private function getCombatAdministration(): string
    {
        $action   = Session::fromGet(C::ACTION);
        $combatId = (int) (Session::fromGet('combatId') ?? -1);
        $combatCode = Session::fromGet(C::COMBAT) ?? '';

        $initiativeTracker  = $this->readerFactory
            ->initiativeTracker()
            ->initiativeTrackerByCode($combatCode);
        if (null !== $initiativeTracker) {
            return $this->initiativeAdminPresenter->presentInitiativePanel();
        }

        $initiativeTracker = $this->readerFactory
            ->initiativeTracker()
            ->initiativeTrackerById($combatId);
        if (null === $initiativeTracker) {
            $initiativeTracker = new InitiativeTracker();
        }

        if (Session::isPostSubmitted()) {
            return $this->handleSubmit($action, $initiativeTracker);
        }

        return match (true) {
            $action === C::EDIT && $combatId !== '' => $this->renderCombatForm($initiativeTracker),
            $action === C::NEW                      => $this->renderCombatForm($initiativeTracker),
            default                                 => $this->renderCombatList(),
        };
    }

    protected function handleSubmit(string $action, InitiativeTracker $initiativeTracker): string
    {
        return match ($action) {
            C::EDIT => $this->handleEditSubmit($initiativeTracker),
            C::NEW  => $this->handleNewSubmit($initiativeTracker),
            default => $this->renderCombatList(),
        };
    }

    protected function handleEditSubmit(InitiativeTracker $initiativeTracker): string
    {
        $changedFields = [];
        $this->initEntity($initiativeTracker, $changedFields);

        if (!$this->controlEntity($initiativeTracker)) {
            $this->toastContent .= $this->toastBuilder->error("Un champ obligatoire n'a pas été saisi ou a une valeur erronnée.");
            return $this->renderCombatForm($initiativeTracker);
        }

        $this->itWriter->updatePartial($initiativeTracker, $changedFields);
        $this->toastContent = $this->toastBuilder->success("Le combat a été correctement mis à jour.");
        return $this->renderCombatForm($initiativeTracker);
    }

    private function initEntity(InitiativeTracker $initiativeTracker, ?array &$changedFields = null): void
    {
        foreach (InitiativeTracker::EDITABLE_FIELDS as $field) {
            $value = Session::fromPost($field, 'err');
            if ($value != 'err' && $initiativeTracker->$field != $value) {
                $initiativeTracker->$field    = $value;
                if ($changedFields !== null) {
                    $changedFields[] = $field;
                }
            }
        }
    }

    private function controlEntity(InitiativeTracker $initiativeTracker): bool
    {
        $blnOk = true;
        if ($initiativeTracker->name == '') {
            $this->toastContent .= $this->toastBuilder->warning("Le nom du combat doit être saisi.");
            $blnOk = false;
        }
        return $blnOk;
    }

    protected function handleNewSubmit(InitiativeTracker $initiativeTracker): string
    {
        $this->initEntity($initiativeTracker);

        if (!$this->controlEntity($initiativeTracker)) {
            $this->toastContent .= $this->toastBuilder->error("Un champ obligatoire n'a pas été saisi ou a une valeur erronnée.");
            return $this->renderCombatForm($initiativeTracker);
        }

        // Gérer wpUserId
        $initiativeTracker->wpUserId = Session::getWpUser()->ID;
        // Gérer itCode
        $initiativeTracker->iTCode = $this->getNewItCode();

        $this->itWriter->insert($initiativeTracker);
        $this->toastContent = $this->toastBuilder->success("Le nouveau combat a été correctement créé.");
        return $this->renderCombatForm($initiativeTracker);
    }

    private function getNewItCode(): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        do {
            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $code .= $chars[random_int(0, 35)];
            }
            $itVerif = $this->readerFactory
                ->initiativeTracker()
                ->initiativeTrackerByCode($code);
        } while (null !== $itVerif);

        return $code;
    }

    private function renderCombatForm(InitiativeTracker $initiativeTracker): string
    {
        if ('' === $initiativeTracker->iTCode) {
            $initiativeTracker->iTCode = $this->getNewItCode();
        }

        $page = new PageForm(
            $this->templateRenderer,
            $this->iTFormBuilder,
            $this->toastContent
        );

        return $page->renderAdmin('', $initiativeTracker ?? new InitiativeTracker());
    }

    private function renderCombatList(): string
    {
        $trackers = $this->readerFactory
            ->initiativeTracker()
            ->allInitiativeTrackers();

        $page = new PageList(
            $this->templateRenderer,
            new InitiativeTrackerTableBuilder()
        );

        return $page->renderAdmin(
            'Liste des combats',
            $trackers,
            ''
        );
    }

    private function getTimelineContent(): string
    {
        $map = $this->readerFactory->map()->mapById($this->mapId);

        $mapTokens = $this->readerFactory
            ->mapToken()
            ->mapTokensByMap($this->mapId);

        $initiatives = $this->readerFactory
            ->initiative()
            ->initiativesByMap($this->mapId);

        return $this->initiativeAdminPresenter->present(
            $map,
            $mapTokens,
            $initiatives
        );
    }
}
