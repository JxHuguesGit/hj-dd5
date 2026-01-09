<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Domain\RpgOrigin;
use src\Page\PageOrigine;
use src\Presenter\MenuPresenter;
use src\Service\RpgOriginQueryService;
use src\Service\Page\OriginPageService;
use src\Presenter\OriginDetailPresenter;

class PublicOrigine extends PublicBase
{
    private RpgOrigin $origin;

    public function __construct(
        private string $slug,
        private RpgOriginQueryService $originQueryService,
        private OriginPageService $pageService,
        private OriginDetailPresenter $presenter,
        private PageOrigine $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->origin = $this->originQueryService->getOriginBySlugOrFail($this->slug);
        $this->title = $this->origin->name;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::ORIGINS);
        $pageView = $this->pageService->build($this->origin);
        $viewData = $this->presenter->present($pageView);
        $viewData[Constant::CST_TITLE] = $this->getTitle();

        return $this->page->render($menu, $viewData);
    }
}
