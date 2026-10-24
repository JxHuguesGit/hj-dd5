<?php

namespace src\Page\Renderer;

use src\Constant\Template as T;
use src\Domain\Entity\InitiativeTracker;
use src\Renderer\TemplateRenderer;
use src\Service\Domain\InitTrackCharacterService;
use src\Service\Reader\InitiativeTrackerReader;
use src\Service\Reader\InitTrackCharacterReader;
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
        $returned = '';
        $sessionId = Session::fromPost('sessionId', -1);
        if ($sessionId==-1) {
            // On arrive sur la page.
            // A-t-on une sessionId en Session ?
            $sessionId = Session::fromSession('sessionId');
            if ($sessionId=='') {
                // On arrive tout neuf sur la page.
                $returned = $this->renderLoginPage();
            } else {
                $initiativeTracker = $this->itReader->initiativeTrackerByCode($sessionId);
                if ($sessionId=='HJO') {
                    $initiativeTracker = new InitiativeTracker();
                }
                // On a une Session identifiée, on l'affiche
                $returned = $this->renderInitiativePage($initiativeTracker);
            }
        } else {
            // Est-on sur une Session identifiée ?
            $initiativeTracker = $this->itReader->initiativeTrackerByCode($sessionId);
            if ($sessionId == 'HJO' || $initiativeTracker->id!='') {
                if ($sessionId=='HJO') {
                    $initiativeTracker = new InitiativeTracker();
                }
                Session::setSession('sessionId', $sessionId);
                // Si oui, on affiche la Session.
                $returned = $this->renderInitiativePage($initiativeTracker);
            } else {
                // Si non, on affiche l'interface permettant de rejoindre une Session.
                // Avec un message éventuellement
                $returned = $this->renderLoginPage();
            }
        }
        return $returned;
    }

    private function renderInitiativePage(InitiativeTracker $initiativeTracker): string
    {
        // Le combat est-il commencé ?
        // S'il n'est pas commencé, on retourne l'écran d'accueil.
        if ($initiativeTracker->active==0) {
            return $this->renderer->render(
                T::PUBLIC_PLAYER_VIEW,
                [
                    '',
                    date('H:i'),
                    '',
                    '',
                    '',
                    '',//PLUGINS_DD5,
                    date('His'),
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
                date('His'),
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
