<?php
namespace src\Controller\Public;

use src\Domain\Entity\Feat;
use src\Page\Renderer\PageFeat;
use src\Presenter\ContentBuilder\FeatDetailContentBuilder;
use src\Presenter\Detail\FeatDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Page\FeatPageService;

class PublicFeat extends PublicBase
{
    public function __construct(
        private Feat $feat,
        private FeatPageService $pageService,
        private FeatDetailPresenter $presenter,
        private FeatDetailContentBuilder $contentBuilder,
        private PageFeat $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->title = $this->feat->name;
    }

    public function getTitle(): string
    {
        return $this->title ?? '';
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render();
        if ($this->feat->id === null) {
            return $this->page->render($menu, '');
        }
        $pageView = $this->pageService->build($this->feat);
        $viewData = $this->presenter->present($pageView);
        $content = $this->contentBuilder->build($viewData);
        return $this->page->render($menu, $content);
    }
}
