<?php
namespace src\Factory\Controller;


use src\Controller\Public\PublicInitiative;
use src\Domain\Entity\Combat;
use src\Factory\ReaderFactory;
use src\Page\Renderer\PageInitiative;
use src\Presenter\ContentBuilder\InitiativeContentBuilder;
use src\Presenter\ListPresenter\InitiativeListPresenter;
use src\Renderer\TemplateRenderer;
use src\Utils\Session;

class InitiativeControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private TemplateRenderer $renderer
    ) {}


    public function createController(): PublicInitiative
    {
        return new PublicInitiative(
            new PageInitiative(
                $this->readerFactory->initiativeTracker(),
                $this->renderer,
            )
        );
    }
}
