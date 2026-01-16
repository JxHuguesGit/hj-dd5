<?php
namespace src\Controller\Public;

use src\Constant\Constant;
use src\Domain\Origin as DomainOrigin;
use src\Page\PageOrigine;
use src\Presenter\Detail\OriginDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Reader\OriginReader;
use src\Service\OriginPageService;

class PublicOrigine extends PublicBase
{
    private ?DomainOrigin $origin;

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
        $pageView = $this->pageService->build($this->origin);
        $viewData = $this->presenter->present($pageView);
        return $this->page->render($menu, $this->title, $viewData);
    }
}
