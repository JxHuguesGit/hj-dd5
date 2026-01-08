<?php
namespace src\Router;

use src\Controller\PublicBase;
use src\Controller\PublicFeat;
use src\Factory\ServiceFactory;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageFeat;
use src\Presenter\FeatDetailPresenter;

class FeatRouter
{
    public function match(string $path, ServiceFactory $factory): ?PublicBase
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
                $factory->getRpgFeatService(),
                $factory->getRpgFeatQueryService(),
                new FeatDetailPresenter(),
                new PageFeat(new TemplateRenderer()),
                new MenuPresenter(PageRegistry::getInstance()->all(), 'feats')
            );
        }

        return null;
    }
}
