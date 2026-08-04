<?php
namespace src\Controller\Public;

use src\Page\Renderer\PageItemTool;
use src\Presenter\MenuPresenter;
use src\Presenter\ViewModel\ToolPageView;

final class PublicItemToolDetail extends PublicBase
{
    public function __construct(
        private MenuPresenter $menuPresenter,
        private ToolPageView $pageView,
        private PageItemTool $page,
    ) {
        $this->title = $this->pageView->getName();
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render();

        return $this->page->render(
            $menu,
            $this->pageView
        );
    }
}
