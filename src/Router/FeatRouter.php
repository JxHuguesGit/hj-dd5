<?php
namespace src\Router;

use src\Controller\PublicBase;
use src\Controller\PublicFeat;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageFeat;
use src\Presenter\Detail\FeatDetailPresenter;
use src\Service\FeatPageService;

class FeatRouter
{
    public function match(string $path, ReaderFactory $factory, ServiceFactory $serviceFactory): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'une catégorie de dons ---
        if (preg_match('#^feats-(.+)$#', $path, $matches)) {
            $typeSlug = $matches[1];
            $controllerClass = 'src\\Controller\\PublicFeat' . ucfirst($typeSlug);
            if (class_exists($controllerClass)) {
                return new $controllerClass();
            }
        }

        // --- Gestion d'un don individuel ---
        if (preg_match('#^feat-(.+)$#', $path, $matches)) {
            return new PublicFeat(
                $matches[1],
                $factory->feat(),
                new FeatPageService($factory->feat(), $serviceFactory->feat()),
                new FeatDetailPresenter(),
                new PageFeat(new TemplateRenderer()),
                new MenuPresenter(PageRegistry::getInstance()->all(), 'feats')
            );
        }

        return null;
    }
}
