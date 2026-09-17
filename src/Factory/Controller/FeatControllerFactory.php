<?php
namespace src\Factory\Controller;

use src\Constant\Constant as C;
use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicFeat;
use src\Controller\Public\PublicFeatCombat;
use src\Controller\Public\PublicFeatEpic;
use src\Controller\Public\PublicFeatGeneral;
use src\Controller\Public\PublicFeatOrigin;
use src\Domain\Criteria\FeatCriteria;
use src\Domain\Entity\Feat;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Page\PageList;
use src\Page\Renderer\PageFeat;
use src\Presenter\ContentBuilder\FeatCardContentBuilder;
use src\Presenter\ContentBuilder\FeatDetailContentBuilder;
use src\Presenter\Detail\FeatDetailPresenter;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Page\FeatPageService;

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
            $this->serviceFactory->featPreRequis(),
            $this->readerFactory->featType(),
            $this->readerFactory->reference(),
            $this->readerFactory->featAbility(),
            $this->readerFactory->ability()
        );
        $page = new PageList(
            $this->renderer,
            new FeatCardContentBuilder()
        );
        $menu = new MenuPresenter(
            PageRegistry::getInstance()->all(),
            C::FEATS
        );
        $featType = $this->readerFactory
            ->featType()
            ->featTypeBySlug($slug);

        $criteria = new FeatCriteria();
        $criteria->featTypeId = $featType->id;

        return new $controllerClass(
            $featReader,
            $presenter,
            $page,
            $menu,
            $criteria
        );
    }

    public function createDetailController(Feat $feat): PublicFeat
    {
        return new PublicFeat(
            $feat,
            new FeatPageService(
                $this->readerFactory->feat(),
                $this->readerFactory->origin()
            ),
            new FeatDetailPresenter(
                $this->serviceFactory->featPreRequis()
            ),
            new FeatDetailContentBuilder(),
            new PageFeat($this->renderer),
            new MenuPresenter(PageRegistry::getInstance()->all(), C::FEATS)
        );
    }

    public function getReaderFactory(): ReaderFactory
    {
        return $this->readerFactory;
    }
}
