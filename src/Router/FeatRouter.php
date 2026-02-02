<?php
namespace src\Router;

use src\Constant\Constant;
use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicFeat;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageFeat;
use src\Page\PageList;
use src\Presenter\Detail\FeatDetailPresenter;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\TableBuilder\FeatTableBuilder;
use src\Service\Page\FeatPageService;

class FeatRouter
{
    public function __construct(
        private ReaderFactory $factory,
        private ServiceFactory $serviceFactory
    ) {}
    
    public function match(string $path): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'une catégorie de dons ---
        if ($slug = $this->matchPattern($path, Routes::FEATS_PATTERN)) {
            $controllerClass = 'src\\Controller\\Public\\PublicFeat' . ucfirst($slug);
            if (class_exists($controllerClass)) {
                return new $controllerClass(
                    $this->factory->feat(),
                    new FeatListPresenter(
                        $this->factory->origin(),
                        $this->serviceFactory->wordPress()
                    ),
                    new PageList(
                        new TemplateRenderer(),
                        new FeatTableBuilder($this->factory->origin())
                    ),
                    new MenuPresenter(PageRegistry::getInstance()->all(), Constant::FEATS)
                );
            }
        }

        // --- Gestion d'un don individuel ---
        if ($slug = $this->matchPattern($path, Routes::FEAT_PATTERN)) {
            return new PublicFeat(
                $slug,
                $this->factory->feat(),
                new FeatPageService(
                    $this->factory->feat(),
                    $this->factory->origin()
                ),
                new FeatDetailPresenter(
                    $this->serviceFactory->wordPress()
                ),
                new PageFeat(new TemplateRenderer()),
                new MenuPresenter(PageRegistry::getInstance()->all(), Constant::FEATS)
            );
        }

        return null;
    }

    private function matchPattern(string $path, string $pattern): ?string
    {
        return preg_match($pattern, $path, $matches) ? $matches[1] : null;
    }
}
