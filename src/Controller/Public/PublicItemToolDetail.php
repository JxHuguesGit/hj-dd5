<?php
namespace src\Controller\Public;

use src\Constant\Constant as C;
use src\Page\Renderer\PageDetail;
use src\Presenter\Detail\ToolDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Presenter\ViewModel\ToolPageView;

final class PublicItemToolDetail extends PublicBase
{
    public function __construct(
        private ToolDetailPresenter $detailPresenter,
        private MenuPresenter $menuPresenter,
        private ToolPageView $pageView,
        private PageDetail $page,
    ) {
        $this->title = $this->pageView->getName();
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(C::ITEMS);
        $viewData = $this->detailPresenter->present($this->pageView);
        return $this->page->render($menu, $this->getTitle(), $viewData);
    }
}
