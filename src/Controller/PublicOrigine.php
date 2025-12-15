<?php
namespace src\Controller;

use src\Domain\RpgOrigin;
use src\Page\PageOrigine;
use src\Presenter\MenuPresenter;
use src\Service\RpgOriginQueryService;
use src\Presenter\OriginDetailPresenter;
use src\Service\RpgOriginService;

class PublicOrigine extends PublicBase
{
    private ?RpgOrigin $origin;

    public function __construct(
        private string $slug,
        private RpgOriginService $originService,
        private RpgOriginQueryService $originQueryService,
        private OriginDetailPresenter $presenter,
        private PageOrigine $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->origin = $originQueryService->getOriginBySlugOrFail($this->slug);
        $this->title = $this->origin->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render('origines');
        $nav = $this->originQueryService->getPreviousAndNext($this->origin);
        $originFeat = $this->originService->getFeat($this->origin);
        $originTool = $this->originService->getTool($this->origin);
        $viewData = $this->presenter->present(
            $this->origin,
            $nav['prev'],
            $nav['next'],
            $originFeat,
            $originTool,
        );
        $viewData['title'] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
