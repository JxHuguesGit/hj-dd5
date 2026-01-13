<?php
namespace src\Router;

use src\Constant\Constant;
use src\Controller\PublicBase;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageList;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\ListPresenter\OriginListPresenter;
use src\Presenter\ListPresenter\SkillListPresenter;
use src\Presenter\ListPresenter\SpeciesListPresenter;
use src\Presenter\TableBuilder\FeatTableBuilder;
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
                    Constant::SPECIES => new $controllerClass(
                        $readerFactory->species(),
                        new SpeciesListPresenter(),
                        new PageList(
                            new TemplateRenderer(),
                            new SpeciesTableBuilder()
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SPECIES)
                    ),
                    Constant::SKILLS => new $controllerClass(
                        $readerFactory->skill(),
                        new SkillListPresenter(),
                        new PageList(
                            new TemplateRenderer(),
                            new SkillTableBuilder($serviceFactory->skill())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SKILLS)
                    ),
                    Constant::FEATS => new $controllerClass(
                        $readerFactory->feat(),
                        new FeatListPresenter(),
                        new PageList(
                            new TemplateRenderer(),
                            new FeatTableBuilder($readerFactory->origin())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), Constant::FEATS)
                    ),
                    default    => new $controllerClass(),
                };
            } else {
                echo "Controller class $controllerClass does not exist.";
            }
        }
        return null;
    }
}
