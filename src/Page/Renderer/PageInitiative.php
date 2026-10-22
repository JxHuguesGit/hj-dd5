<?php

namespace src\Page\Renderer;

use src\Constant\Template as T;
use src\Domain\Entity\Combat;
use src\Domain\Entity\InitiativeTracker;
use src\Presenter\ContentBuilder\InitiativeContentBuilder;
use src\Presenter\ListPresenter\InitiativeListPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Reader\CombatParticipantReader;
use src\Service\Reader\InitiativeTrackerReader;
use src\Utils\Session;

class PageInitiative
{
    public function __construct(
        private InitiativeTrackerReader $itReader,
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
        return $this->renderer->render(
            T::PUBLIC_PLAYER_VIEW,
            [
                '',
                '',
                date('H:i'),
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
