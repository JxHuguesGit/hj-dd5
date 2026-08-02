<?php
namespace src\Controller\Public;

use src\Page\Renderer\PageItemWeapon;
use src\Presenter\MenuPresenter;
use src\Presenter\ViewModel\WeaponPageView;

final class PublicItemWeaponDetail extends PublicBase
{
    public function __construct(
        private MenuPresenter $menuPresenter,
        private WeaponPageView $pageView,
        private PageItemWeapon $page,
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
