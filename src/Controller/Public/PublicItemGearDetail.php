<?php
namespace src\Controller\Public;

use src\Page\Renderer\PageItemGear;
use src\Presenter\MenuPresenter;
use src\Presenter\ViewModel\GearPageView;

final class PublicItemGearDetail extends PublicBase
{
    public function __construct(
        private MenuPresenter $menuPresenter,
        private GearPageView $pageView,
        private PageItemGear $page,
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
