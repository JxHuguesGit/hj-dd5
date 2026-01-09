<?php
namespace src\Router;

use src\Controller\PublicBase;
use src\Factory\ServiceFactory;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageOriginList;
use src\Page\PageList;
use src\Presenter\OriginListPresenter;
use src\Presenter\RpgOriginTableBuilder;
use src\Presenter\ListPresenter\SkillListPresenter;
use src\Presenter\ListPresenter\SpeciesListPresenter;
use src\Presenter\TableBuilder\SkillTableBuilder;
use src\Presenter\TableBuilder\SpeciesTableBuilder;

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
                        $factory->getSpecieReader(),
                        new SpeciesListPresenter(),
                        new PageList(
                            new TemplateRenderer(),
                            new SpeciesTableBuilder()
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), 'species')
                    ),
                    'skills' => new $controllerClass(
                        $factory->getSkillReader(),
                        new SkillListPresenter(),
                        new PageList(
                            new TemplateRenderer(),
                            new SkillTableBuilder()
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), 'skills')
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
