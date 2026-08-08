<?php
namespace src\Controller\Public;

use src\Domain\Entity\Origin;
use src\Page\Renderer\PageOrigine;
use src\Presenter\ContentBuilder\OriginDetailContentBuilder;
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
        private OriginDetailContentBuilder $contentBuilder,
        private PageOrigine $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->origin = $this->originReader->originBySlug($this->slug);
        $this->title = $this->origin->name;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render();
        $pageView = $this->pageService->build($this->origin);
        $viewData = $this->presenter->present($pageView);
        $contentHtml = $this->contentBuilder->build($viewData);
        return $this->page->render($menu, $contentHtml);
    }

    public function getStepSideContent(): string
    {
        return $this->page->renderContent($this->getViewData());
    }
}
