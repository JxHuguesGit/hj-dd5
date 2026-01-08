<?php
namespace src\Router;

use src\Controller\PublicBase;
use src\Factory\ServiceFactory;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageOriginList;
use src\Page\PageSpeciesList;
use src\Presenter\OriginListPresenter;
use src\Presenter\RpgOriginTableBuilder;
use src\Presenter\RpgSpeciesTableBuilder;
use src\Presenter\SpeciesListPresenter;

class RegistryRouter
{
    public function match(string $path, ServiceFactory $factory): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Partie statique via PageRegistry ---
        $registry = PageRegistry::getInstance();
        $pageElement = $registry->get($path);

        if ($pageElement) {
            $controllerClass = 'src\\Controller\\Public' . ucfirst($pageElement->getSlug());
                        
            if (class_exists($controllerClass)) {
                return match($pageElement->getSlug()) {
                    'origines' => new $controllerClass(
                        $factory->getRpgOriginQueryService(),
                        new OriginListPresenter(),
                        new PageOriginList(
                            new TemplateRenderer(),
                            new RpgOriginTableBuilder($factory->getRpgOriginService())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), 'origines')
                    ),
                    'species' => new $controllerClass(
                        $factory->getRpgSpeciesQueryService(),
                        new SpeciesListPresenter(),
                        new PageSpeciesList(
                            new TemplateRenderer(),
                            new RpgSpeciesTableBuilder($factory->getRpgSpeciesService())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), 'species')
                    ),
                    'feats'    => new $controllerClass($factory->getRpgFeatService()),
                    default    => new $controllerClass(),
                };
            } else {
                echo "Controller class $controllerClass does not exist.";
            }
        }
        return null;
    }
}
