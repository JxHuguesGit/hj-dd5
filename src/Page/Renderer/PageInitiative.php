<?php

namespace src\Page\Renderer;

use src\Constant\Template as T;
use src\Domain\Entity\InitiativeTracker;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\InitTrackCharacterService;
use src\Service\Reader\InitiativeTrackerReader;
use src\Utils\Session;

class PageInitiative
{
    public function __construct(
        private InitiativeTrackerReader $itReader,
        private InitTrackCharacterService $initTrackCharService,
        private TemplateRenderer $renderer,
    ) {}

    public function render(): string
    {
        if (Session::fromGet('action') === 'logout') {
            Session::unsetSession('sessionId');
            return $this->renderLoginPage();
        }

        $initiativeTracker = $this->getInitiativeTracker();
        if (null === $initiativeTracker) {
            return $this->renderLoginPage();
        }

        return $this->renderInitiativePage($initiativeTracker);
    }

    private function getInitiativeTracker(): ?InitiativeTracker
    {
        $sessionId = $this->resolveSessionId();

        if ($sessionId === '') {
            return null;
        }

        $initiativeTracker = $this->itReader->initiativeTrackerByCode($sessionId);

        if (null === $initiativeTracker || $initiativeTracker->id === '') {
            return null;
        }

        Session::setSession('sessionId', $sessionId);

        return $initiativeTracker;
    }

    private function resolveSessionId(): string
    {
        if (Session::isPostSubmitted()) {
            $sessionId = Session::fromPost('sessionId', '');

            if ($sessionId !== '') {
                return $sessionId;
            }
        }

        $sessionId = Session::fromGet('combat');

        if ($sessionId !== '') {
            return $sessionId;
        }

        return Session::fromSession('sessionId');
    }

    private function renderInitiativePage(InitiativeTracker $initiativeTracker): string
    {
        // Le combat est-il commencé ?
        // S'il n'est pas commencé, on retourne l'écran d'accueil.
        if ($initiativeTracker->active == 0) {
            return $this->renderer->render(
                T::PUBLIC_PLAYER_VIEW,
                [
                    '',
                    date('H:i'),
                    '',
                    '',
                    '',
                    '', //PLUGINS_DD5,
                    $initiativeTracker->iTCode,
                ]
            );
        }

        $orderedQueue = $this->initTrackCharService->getTurnOrder($initiativeTracker);
        // On récupère le premier personnage pour l'afficher en gros
        $firstCharacter = $orderedQueue->first();

        return $this->renderer->render(
            T::PUBLIC_PLAYER_VIEW,
            [
                'combatStarted ' . $firstCharacter->characterType,
                date('H:i'),
                $initiativeTracker->round,
                $this->initTrackCharService->displayCharacter($firstCharacter),
                $this->initTrackCharService->displayQueuedCharacters($orderedQueue),
                PLUGINS_DD5,
                $initiativeTracker->iTCode,
            ]
        );
    }

    private function renderLoginPage(): string
    {
        return $this->renderer->render(
            T::PUBLIC_JOIN_LOGIN,
            []
        );
    }
}
