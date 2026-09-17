<?php
namespace src\Factory\Controller;

use src\Constant\Constant as C;
use src\Controller\Public\PublicSpecie;
use src\Domain\Entity\Specie;
use src\Factory\{ReaderFactory, ServiceFactory};
use src\Model\PageRegistry;
use src\Page\Renderer\PageSpecie;
use src\Presenter\ContentBuilder\SpecieDetailContentBuilder;
use src\Presenter\Detail\SpecieDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Page\SpeciePageService;
use src\Service\Formatter\ShortcodeFormatter;

class SpecieControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createDetailController(Specie $specie): PublicSpecie
    {
        return new PublicSpecie(
            $specie,
            new SpeciePageService(
                $this->serviceFactory->specie(),
                $this->readerFactory->species()
            ),
            new SpecieDetailPresenter(
                $this->readerFactory->reference(),
                $this->serviceFactory->wordPress(),
                new ShortcodeFormatter($this->serviceFactory->wordPress())
            ),
            new SpecieDetailContentBuilder(
                new ShortcodeFormatter($this->serviceFactory->wordPress())
            ),
            new PageSpecie($this->renderer),
            new MenuPresenter(PageRegistry::getInstance()->all(), C::SPECIES)
        );
    }

    public function getReaderFactory(): ReaderFactory
    {
        return $this->readerFactory;
    }
}

