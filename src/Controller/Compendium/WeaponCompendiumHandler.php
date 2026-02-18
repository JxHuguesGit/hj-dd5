<?php
namespace src\Controller\Compendium;

use src\Page\PageList;
use src\Presenter\ListPresenter\WeaponListPresenter;
use src\Service\Reader\WeaponReader;

final class WeaponCompendiumHandler implements CompendiumHandlerInterface
{
    public function __construct(
        private WeaponReader $weaponReader,
        private WeaponListPresenter $presenter,
        private PageList $page,
    ) {}

    public function render(): string
    {
        $weapons = $this->weaponReader->allWeapons();
        $content = $this->presenter->present($weapons);
        return $this->page->renderAdmin('', $content);
    }
}
