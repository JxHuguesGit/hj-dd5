<?php
namespace src\Factory\Controller;

use src\Constant\Constant as C;
use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicFeat;
use src\Controller\Public\PublicFeatCombat;
use src\Controller\Public\PublicFeatEpic;
use src\Controller\Public\PublicFeatGeneral;
use src\Controller\Public\PublicFeatOrigin;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Page\PageList;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\MenuPresenter;
use src\Presenter\TableBuilder\FeatTableBuilder;
use src\Renderer\TemplateRenderer;

final class FeatControllerFactory
{
    private const CATEGORY_CONTROLLERS = [
        C::COMBAT  => PublicFeatCombat::class,
        C::EPIC    => PublicFeatEpic::class,
        C::GENERAL => PublicFeatGeneral::class,
        C::ORIGIN  => PublicFeatOrigin::class,
    ];

    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createCategoryController(string $slug): ?PublicBase
    {
        $controllerClass = self::CATEGORY_CONTROLLERS[$slug] ?? null;
        if (! $controllerClass) {
            return null;
        }

        $featReader = $this->readerFactory->feat();
        $presenter  = new FeatListPresenter(
            $this->readerFactory->origin(),
            $this->readerFactory->featAbility(),
            $this->readerFactory->ability(),
            $this->serviceFactory->wordPress()
        );
        $page = new PageList(
            $this->renderer,
            new FeatTableBuilder()
        );
        $menu = new MenuPresenter(
            PageRegistry::getInstance()->all(),
            C::FEATS
        );
        return new $controllerClass($featReader, $presenter, $page, $menu);
    }

    public function createDetailController(string $slug): PublicFeat
    {
        return new PublicFeat(
            $slug,
            $this->readerFactory->feat(),
            new \src\Service\Page\FeatPageService(
                $this->readerFactory->feat(),
                $this->readerFactory->origin()
            ),
            new \src\Presenter\Detail\FeatDetailPresenter(
                $this->serviceFactory->wordPress()
            ),
            new \src\Page\Renderer\PageFeat($this->renderer),
            new MenuPresenter(PageRegistry::getInstance()->all(), C::FEATS)
        );
    }
}
