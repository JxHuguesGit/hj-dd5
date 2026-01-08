<?php
namespace src\Router;

use src\Controller\PublicBase;
use src\Controller\PublicOrigine;
use src\Factory\ServiceFactory;
use src\Page\PageOrigine;
use src\Presenter\MenuPresenter;
use src\Presenter\OriginDetailPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;

class OriginRouter
{
    public function match(string $path, ServiceFactory $factory): ?PublicBase
    {
        if (!preg_match('#^origine-(.+)$#', $path, $matches)) {
            return null;
        }

        return new PublicOrigine(
            $matches[1],
            $factory->getRpgOriginService(),
            $factory->getRpgOriginQueryService(),
            new OriginDetailPresenter(),
            new PageOrigine(new TemplateRenderer()),
            new MenuPresenter(PageRegistry::getInstance()->all(), 'origines')
        );
    }
}
