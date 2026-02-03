<?php
namespace src\Controller\Public;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Language;
use src\Page\PageList;
use src\Presenter\ListPresenter\GearListPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Reader\ItemReader;

final class PublicItemGear extends PublicBase
{
    private ?Collection $gears = null;

    public function __construct(
        private ItemReader $itemReader,
        private GearListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->gears = $this->itemReader->allGears();
        $this->title = Language::LG_GEAR_TITLE;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::CST_ITEMS);
        $viewData = $this->presenter->present($this->gears);
        return $this->page->render($menu, $this->title, $viewData);
    }
}
