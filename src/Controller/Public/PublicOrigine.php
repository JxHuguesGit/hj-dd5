<?php
namespace src\Controller\Public;

use src\Constant\Constant;
use src\Domain\Entity\Origin;
use src\Page\Renderer\PageOrigine;
use src\Presenter\Detail\OriginDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Page\OriginPageService;
use src\Service\Reader\OriginReader;

class PublicOrigine extends PublicBase
{
    private ?Origin $origin;

    public function __construct(
        private string $slug,
        private OriginReader $originReader,
        private OriginPageService $pageService,
        private OriginDetailPresenter $presenter,
        private PageOrigine $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->origin = $this->originReader->originBySlug($this->slug);
        $this->title = $this->origin->name;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::ORIGINS);
        $viewData = $this->getViewData();
        $viewData[Constant::CST_TITLE] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }

    public function getViewData()
    {
        $pageView = $this->pageService->build($this->origin);
        return $this->presenter->present($pageView);
    }
}
