<?php
namespace src\Factory\Controller;

use src\Controller\Public\PublicInitiative;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Page\Renderer\PageInitiative;
use src\Renderer\TemplateRenderer;

class InitiativeControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createController(): PublicInitiative
    {
        return new PublicInitiative(
            new PageInitiative(
                $this->readerFactory->initiativeTracker(),
                $this->serviceFactory->initTrackCharacter(),
                $this->renderer,
            )
        );
    }
}
