<?php
namespace src\Factory\Controller;


use src\Controller\Public\PublicInitiative;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Page\Renderer\PageInitiative;
use src\Presenter\ContentBuilder\InitiativeContentBuilder;
use src\Presenter\ListPresenter\InitiativeListPresenter;
use src\Renderer\TemplateRenderer;
use src\Utils\Session;

class InitiativeControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}


    public function createController(): PublicInitiative
    {
        $combatId = (int) Session::fromGet('combatId');
        $combat = $this->readerFactory->combat()->combatById($combatId);

        return new PublicInitiative(
            new PageInitiative(
                $combat,
                $this->renderer,
                $this->readerFactory->combatParticipant(),
                new InitiativeListPresenter(),
                new InitiativeContentBuilder(),
            )
        );
    }
}
