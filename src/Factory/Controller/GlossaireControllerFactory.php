<?php
namespace src\Factory\Controller;


use src\Constant\Constant as C;
use src\Controller\Public\PublicGlossaire;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Page\PageList;
use src\Page\Renderer\PageGlossaire;
use src\Presenter\ContentBuilder\GlossaireCardContentBuilder;
use src\Presenter\ContentBuilder\GlossaireContentBuilder;
use src\Presenter\ListPresenter\GlossaireListPresenter;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;

class GlossaireControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createController(): PublicGlossaire
    {
        return new PublicGlossaire(
            $this->serviceFactory->wordpress(),
            new GlossaireListPresenter(),
            new PageList(
                $this->renderer,
                new GlossaireCardContentBuilder()
            ),
            new MenuPresenter (
                PageRegistry::getInstance()->all(),
                C::GLOSSARY
            )
        );
    }
}
