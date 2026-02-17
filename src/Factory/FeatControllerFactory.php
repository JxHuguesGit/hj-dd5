<?php
namespace src\Factory;

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
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory
    ) {}

    public function createCategoryController(string $slug): ?PublicBase
    {
        return match ($slug) {

            'combat' => new PublicFeatCombat(
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

            'epic' => new PublicFeatEpic(
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

            'general' => new PublicFeatGeneral(
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

            'origin' => new PublicFeatOrigin(
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

            default => null,
        };
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
            new \src\Page\PageFeat(new TemplateRenderer()),
            new MenuPresenter(PageRegistry::getInstance()->all(), Constant::FEATS)
        );
    }
}
