<?php
namespace src\Factory\Controller;

use src\Constant\Constant;
use src\Controller\Public\PublicSpecie;
use src\Factory\{ReaderFactory, ServiceFactory};
use src\Model\PageRegistry;
use src\Page\Renderer\PageSpecie;
use src\Presenter\Detail\SpeciesDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Page\SpeciePageService;

class SpecieControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createDetailController(string $slug): PublicSpecie
    {
        return new PublicSpecie(
            $slug,
            $this->readerFactory->species(),
            new SpeciePageService(
                $this->serviceFactory->specie(),
                $this->readerFactory->species()
            ),
            new SpeciesDetailPresenter(
                $this->serviceFactory->wordPress()
            ),
            new PageSpecie($this->renderer),
            new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SPECIES)
        );
    }
}

