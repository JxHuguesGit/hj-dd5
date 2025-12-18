<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Page\PageWeaponList;
use src\Presenter\WeaponListPresenter;
use src\Presenter\MenuPresenter;
use src\Service\RpgWeaponQueryService;

final class PublicItemWeapon extends PublicBase
{
    private ?Collection $weapons = null;

    public function __construct(
        private RpgWeaponQueryService $weaponQueryService,
        private WeaponListPresenter $presenter,
        private PageWeaponList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->weapons = $this->weaponQueryService->getAllWeapons();
        $this->title = 'Les Armes';
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render('items');
        $viewData = $this->presenter->present($this->weapons);
        $viewData['title'] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
