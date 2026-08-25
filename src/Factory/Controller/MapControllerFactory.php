<?php
namespace src\Factory\Controller;


use src\Controller\Public\PublicMap;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Page\Renderer\PageMap;
use src\Renderer\TemplateRenderer;

class MapControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}


    public function createController(): PublicMap
    {
        $map = $this->readerFactory->map()->getActiveMap();

        return new PublicMap(
            new PageMap(
                $map,
                $this->renderer,
                $this->serviceFactory->mapToken(),
                $this->serviceFactory->mapFog()
            )
        );
    }
}
