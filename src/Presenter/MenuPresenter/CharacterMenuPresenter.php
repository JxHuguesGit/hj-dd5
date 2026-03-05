<?php
namespace src\Presenter\MenuPresenter;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Language as L;
use src\Constant\Template as T;
use src\Presenter\MenuPresenter\MenuItemPresenter;
use src\Presenter\ViewModel\MenuItem;
use src\Service\Reader\CharacterReader;
use src\Utils\Html;
use src\Utils\Session;
use src\Utils\UrlGenerator;

class CharacterMenuPresenter
{
    public function __construct(
        private CharacterReader $reader
    ) {}

    public function render(string $currentTab, string $currentId, callable $renderer): string
    {
        $isActiveTab  = $currentTab === C::ONG_CHARACTER;
        $childrenHtml = '';

        // URL de base pour les personnages
        $url = UrlGenerator::admin(C::ONG_CHARACTER, '%d', '', '', [C::STEP => '%s']);

        // ----- 1) Item "Nouveau" -----
        $newItem   = new MenuItem(0, L::NOUVEAU, I::PLUS);
        $presenter = new MenuItemPresenter($newItem, $currentTab, $currentId);

        $childrenHtml .= $renderer(T::ADMINSIDEBARITEM, $presenter->toTemplateAttributesNewCharacter($url));

        // ----- 2) Items "héros" -----
        $heroes = $this->reader->characterByWpUser(Session::getWpUser()->data->ID);

        foreach ($heroes as $hero) {
            $item      = new MenuItem($hero->id, $hero->name, C::USER);
            $presenter = new MenuItemPresenter($item, $currentTab, $currentId);

            $childrenHtml .= $renderer(
                T::ADMINSIDEBARITEM,
                $presenter->toTemplateAttributesCharacter($url, $hero->createStep)
            );
        }

        // UL contenant les enfants
        $ul = Html::getUl($childrenHtml, [C::CSSCLASS => implode(' ', [B::NAV, B::NAV_TREEVIEW])]);

        // ----- 3) Item parent -----
        $attributes = [
            $isActiveTab ? B::MENU_OPEN : '',
            '#',
            $isActiveTab ? C::ACTIVE : '',
            C::USERS,
            L::CHARACTERS,
            '',
            $ul,
            '', '',
        ];

        return $renderer(T::ADMINSIDEBARITEM, $attributes);
    }
}
