<?php
namespace src\Factory\Controller;


use src\Constant\Constant as C;
use src\Controller\Public\PublicHomebrew;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Page\PageList;
use src\Presenter\ContentBuilder\HomebrewCardContentBuilder;
use src\Presenter\ListPresenter\HomebrewListPresenter;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;

class HomebrewControllerFactory
{
    public function __construct(
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createController(): PublicHomebrew
    {
        return new PublicHomebrew(
            $this->serviceFactory->wordpress(),
            new HomebrewListPresenter(),
            new PageList(
                $this->renderer,
                new HomebrewCardContentBuilder(
                    $this->serviceFactory->wordpress()
                )
            ),
            new MenuPresenter (
                PageRegistry::getInstance()->all(),
                C::GLOSSARY
            )
        );
    }
}
