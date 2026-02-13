<?php
namespace src\Router;

use src\Constant\Constant;
use src\Controller\Public\PublicBase;
use src\Controller\Utilities;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageList;
use src\Presenter\ListPresenter\{FeatListPresenter, OriginListPresenter, SkillListPresenter, SpeciesListPresenter, SpellListPresenter};
use src\Presenter\Modal\SpellFilterModalPresenter;
use src\Presenter\TableBuilder\{FeatTableBuilder, OriginTableBuilder, SkillTableBuilder, SpeciesTableBuilder, SpellTableBuilder};
use src\Presenter\MenuPresenter;
use src\Service\Domain\SpellService;

class RegistryRouter
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory
    ) {}
    
    public function match(string $path): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Partie statique via PageRegistry ---
        $registry = PageRegistry::getInstance();
        $pageElement = $registry->get($path);

        if ($pageElement) {
            $controllerClass = 'src\\Controller\\Public\\Public' . ucfirst($pageElement->getSlug());
                        
            if (class_exists($controllerClass)) {
                return match($pageElement->getSlug()) {
                    Constant::ORIGINES => new $controllerClass(
                        $this->readerFactory->origin(),
                        new OriginListPresenter(
                            $this->serviceFactory->origin()
                        ),
                        new PageList(
                            new TemplateRenderer(),
                            new OriginTableBuilder($this->serviceFactory->origin(), $this->readerFactory->origin())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), Constant::ORIGINES)
                    ),
                    Constant::SPECIES => new $controllerClass(
                        $this->readerFactory->species(),
                        new SpeciesListPresenter(
                            $this->serviceFactory->wordPress()
                        ),
                        new PageList(
                            new TemplateRenderer(),
                            new SpeciesTableBuilder()
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SPECIES)
                    ),
                    Constant::SKILLS => new $controllerClass(
                        $this->readerFactory->skill(),
                        new SkillListPresenter(
                            $this->serviceFactory->skill()
                        ),
                        new PageList(
                            new TemplateRenderer(),
                            new SkillTableBuilder($this->serviceFactory->skill())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SKILLS)
                    ),
                    Constant::FEATS => new $controllerClass(
                        $this->readerFactory->feat(),
                        new FeatListPresenter(
                            $this->readerFactory->origin(),
                            $this->serviceFactory->wordPress()
                        ),
                        new PageList(
                            new TemplateRenderer(),
                            new FeatTableBuilder()
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), Constant::FEATS)
                    ),
                    Constant::SPELLS => new $controllerClass(
                        new SpellService(
                            $this->serviceFactory->wordPress()
                        ),
                        new SpellListPresenter(
                            $this->readerFactory->spell(),
                            $this->serviceFactory->wordPress()
                        ),
                        new PageList(
                            new TemplateRenderer(),
                            new SpellTableBuilder($this->readerFactory->spell())
                        ),
                        new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SPELLS),
                        new SpellFilterModalPresenter(
                            new Utilities()
                        )
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
