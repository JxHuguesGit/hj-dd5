<?php
namespace src\Controller\Public;

use src\Constant\Constant as C;
use src\Page\Renderer\PageDetail;
use src\Presenter\Detail\GearDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Presenter\ViewModel\GearPageView;

final class PublicItemGearDetail extends PublicBase
{
    public function __construct(
        private GearDetailPresenter $detailPresenter,
        private MenuPresenter $menuPresenter,
        private GearPageView $pageView,
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
