<?php
namespace src\Controller\Public;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Language;
use src\Page\PageList;
use src\Presenter\ListPresenter\WeaponListPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Reader\WeaponReader;

final class PublicItemWeapon extends PublicBase
{
    private ?Collection $weapons = null;

    public function __construct(
        private WeaponReader $weaponReader,
        private WeaponListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->weapons = $this->weaponReader->allWeapons();
        $this->title = Language::LG_WEAPONS_TITLE;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::CST_ITEMS);
        $viewData = $this->presenter->present($this->weapons);
        return $this->page->render($menu, $this->title, $viewData);
    }
}
