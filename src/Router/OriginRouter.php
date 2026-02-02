<?php
namespace src\Router;

use src\Constant\Constant;
use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicOrigine;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Page\PageOrigine;
use src\Presenter\MenuPresenter;
use src\Presenter\Detail\OriginDetailPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Service\Page\OriginPageService;

class OriginRouter
{
    public function __construct(
        private ReaderFactory $factory,
        private ServiceFactory $serviceFactory
    ) {}

    public function match(string $path): ?PublicBase
    {
        if (!preg_match(Routes::ORIGIN_PATTERN, $path, $matches)) {
            return null;
        }

        return new PublicOrigine(
            $matches[1],
            $this->factory->origin(),
            new OriginPageService($this->serviceFactory->origin(), $this->factory->origin()),
            new OriginDetailPresenter(
                $this->serviceFactory->wordPress()
            ),
            new PageOrigine(new TemplateRenderer()),
            new MenuPresenter(PageRegistry::getInstance()->all(), Constant::ORIGINES)
        );
    }
}
