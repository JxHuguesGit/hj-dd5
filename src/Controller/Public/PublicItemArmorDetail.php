<?php
namespace src\Controller\Public;

use src\Constant\Constant;
use src\Page\PageDetail;
use src\Presenter\Detail\ArmorDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Presenter\ViewModel\ArmorPageView;

final class PublicItemArmorDetail extends PublicBase
{
    public function __construct(
        private ArmorDetailPresenter $detailPresenter,
        private MenuPresenter $menuPresenter,
        private ArmorPageView $pageView,
        private PageDetail $page,
    ) {
        $this->title = $this->pageView->getName();
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::CST_ITEMS);
        $viewData = $this->detailPresenter->present($this->pageView);
        return $this->page->render($menu, $this->getTitle(), $viewData);
    }
}
