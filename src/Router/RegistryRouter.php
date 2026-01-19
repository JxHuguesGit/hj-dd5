<?php
namespace src\Router;

use src\Constant\Constant;
use src\Controller\Public\PublicBase;
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
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\TableBuilder\FeatTableBuilder;
use src\Presenter\TableBuilder\OriginTableBuilder;
use src\Presenter\TableBuilder\SkillTableBuilder;
use src\Presenter\TableBuilder\SpeciesTableBuilder;
use src\Presenter\TableBuilder\SpellTableBuilder;
use src\Service\SpellService;

class RegistryRouter
{
    public function match(string $path, ReaderFactory $readerFactory, ServiceFactory $serviceFactory): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Partie statique via PageRegistry ---
        $registry = PageRegistry::getInstance();
        $pageElement = $registry->get($path);

        if ($pageElement) {
            $controllerClass = 'src\\Controller\\Public\\Public' . ucfirst($pageElement->getSlug());
                        
            if (class_exists($controllerClass)) {
                return match($pageElement->getSlug()) {
                    'origines' => new $controllerClass(
                        $readerFactory->origin(),
                        new OriginListPresenter(
                            $serviceFactory->origin()
                        ),
                        new PageList(
                            new TemplateRenderer(),
                            new OriginTableBuilder($serviceFactory->origin(), $readerFactory->origin())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), 'origines')
                    ),
                    Constant::SPECIES => new $controllerClass(
                        $readerFactory->species(),
                        new SpeciesListPresenter(
                            $serviceFactory->wordPress()
                        ),
                        new PageList(
                            new TemplateRenderer(),
                            new SpeciesTableBuilder()
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SPECIES)
                    ),
                    Constant::SKILLS => new $controllerClass(
                        $readerFactory->skill(),
                        new SkillListPresenter(
                            $serviceFactory->skill()
                        ),
                        new PageList(
                            new TemplateRenderer(),
                            new SkillTableBuilder($serviceFactory->skill())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SKILLS)
                    ),
                    Constant::FEATS => new $controllerClass(
                        $readerFactory->feat(),
                        new FeatListPresenter(
                            $readerFactory->origin(),
                            $serviceFactory->wordPress()
                        ),
                        new PageList(
                            new TemplateRenderer(),
                            new FeatTableBuilder($readerFactory->origin())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), Constant::FEATS)
                    ),
                    Constant::SPELLS => new $controllerClass(
                        new SpellService(
                            $serviceFactory->wordPress()
                        ),
                        new SpellListPresenter(
                            $readerFactory->spell(),
                            $serviceFactory->wordPress()
                        ),
                        new PageList(
                            new TemplateRenderer(),
                            new SpellTableBuilder($readerFactory->spell())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SPELLS)
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
