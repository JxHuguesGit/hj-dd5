<?php
namespace src\Router;

use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicOrigine;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Page\PageOrigine;
use src\Presenter\MenuPresenter;
use src\Presenter\Detail\OriginDetailPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Service\OriginPageService;

class OriginRouter
{
    public function match(string $path, ReaderFactory $factory, ServiceFactory $serviceFactory): ?PublicBase
    {
        if (!preg_match('#^origine-(.+)$#', $path, $matches)) {
            return null;
        }

        return new PublicOrigine(
            $matches[1],
            $factory->origin(),
            new OriginPageService($serviceFactory->origin(), $factory->origin()),
            new OriginDetailPresenter(
                $serviceFactory->wordPress()
            ),
            new PageOrigine(new TemplateRenderer()),
            new MenuPresenter(PageRegistry::getInstance()->all(), 'origines')
        );
    }
}
