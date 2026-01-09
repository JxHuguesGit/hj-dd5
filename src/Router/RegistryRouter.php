<?php
namespace src\Router;

use src\Controller\PublicBase;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageList;
use src\Presenter\ListPresenter\OriginListPresenter;
use src\Presenter\ListPresenter\SkillListPresenter;
use src\Presenter\ListPresenter\SpeciesListPresenter;
use src\Presenter\TableBuilder\OriginTableBuilder;
use src\Presenter\TableBuilder\SkillTableBuilder;
use src\Presenter\TableBuilder\SpeciesTableBuilder;

class RegistryRouter
{
    public function match(string $path, ReaderFactory $readerFactory, ServiceFactory $serviceFactory): ?PublicBase
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
                        $readerFactory->origin(),
                        new OriginListPresenter(),
                        new PageList(
                            new TemplateRenderer(),
                            new OriginTableBuilder($serviceFactory->origin(), $readerFactory->origin())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), 'origines')
                    ),
                    'species' => new $controllerClass(
                        $readerFactory->species(),
                        new SpeciesListPresenter(),
                        new PageList(
                            new TemplateRenderer(),
                            new SpeciesTableBuilder()
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), 'species')
                    ),
                    'skills' => new $controllerClass(
                        $readerFactory->skill(),
                        new SkillListPresenter(),
                        new PageList(
                            new TemplateRenderer(),
                            new SkillTableBuilder()
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), 'skills')
                    ),
                    'feats'    => new $controllerClass($readerFactory->feat()),
                    default    => new $controllerClass(),
                };
            } else {
                echo "Controller class $controllerClass does not exist.";
            }
        }
        return null;
    }
}
