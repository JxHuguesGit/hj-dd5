<?php
namespace src\Controller\Public;

use src\Domain\Entity\Specie;
use src\Page\Renderer\PageSpecie;
use src\Presenter\ContentBuilder\SpecieDetailContentBuilder;
use src\Presenter\Detail\SpecieDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Page\SpeciePageService;

class PublicSpecie extends PublicBase
{

    public function __construct(
        private Specie $species,
        private SpeciePageService $pageService,
        private SpecieDetailPresenter $presenter,
        private SpecieDetailContentBuilder $contentBuilder,
        private PageSpecie $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->title = $this->species->name;
    }

    public function getTitle(): string
    {
        return $this->title ?? '';
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render();
        $pageView = $this->pageService->build($this->species);
        $viewData = $this->presenter->present($pageView);
        $contentHtml = $this->contentBuilder->build($viewData);
        return $this->page->render($menu, $contentHtml);
    }
}
