<?php

namespace src\Controller\Public;

use src\Page\Renderer\PageItemArmor;
use src\Presenter\MenuPresenter;
use src\Presenter\ViewModel\ArmorPageView;

final class PublicItemArmorDetail extends PublicBase
{
    public function __construct(
        private MenuPresenter $menuPresenter,
        private ArmorPageView $pageView,
        private PageItemArmor $page,
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
