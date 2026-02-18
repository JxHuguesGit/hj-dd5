<?php
namespace src\Factory\Controller;

use src\Constant\Constant;
use src\Controller\Public\{
    PublicBase,
    PublicFeat,
    PublicFeatCombat,
    PublicFeatEpic,
    PublicFeatGeneral,
    PublicFeatOrigin,
};
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Presenter\MenuPresenter;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\TableBuilder\FeatTableBuilder;
use src\Renderer\TemplateRenderer;
use src\Page\PageList;

final class FeatControllerFactory
{
    private const CATEGORY_CONTROLLERS = [
        'combat'  => PublicFeatCombat::class,
        'epic'    => PublicFeatEpic::class,
        'general' => PublicFeatGeneral::class,
        'origin'  => PublicFeatOrigin::class,
    ];

    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createCategoryController(string $slug): ?PublicBase
    {
        $controllerClass = self::CATEGORY_CONTROLLERS[$slug] ?? null;
        if (!$controllerClass) {
            return null;
        }

        $featReader = $this->readerFactory->feat();
        $presenter = new FeatListPresenter(
            $this->readerFactory->origin(),
            $this->serviceFactory->wordPress()
        );
        $page = new PageList(
            $this->renderer,
            new FeatTableBuilder()
        );
        $menu = new MenuPresenter(
            PageRegistry::getInstance()->all(),
            Constant::FEATS
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
            new \src\Page\PageFeat($this->renderer),
            new MenuPresenter(PageRegistry::getInstance()->all(), Constant::FEATS)
        );
    }
}
