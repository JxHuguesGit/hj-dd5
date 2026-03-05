<?php
namespace src\Presenter\MenuPresenter;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Template;
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
        $isActiveTab  = $currentTab === Constant::ONG_CHARACTER;
        $childrenHtml = '';

        // URL de base pour les personnages
        $url = UrlGenerator::admin(Constant::ONG_CHARACTER, '%d', '', '', ['step' => '%s']);

        // ----- 1) Item "Nouveau" -----
        $newItem   = new MenuItem(0, 'Nouveau', Icon::IPLUS);
        $presenter = new MenuItemPresenter($newItem, $currentTab, $currentId);

        $childrenHtml .= $renderer(Template::ADMINSIDEBARITEM, $presenter->toTemplateAttributesNewCharacter($url));

        // ----- 2) Items "héros" -----
        $heroes = $this->reader->characterByWpUser(Session::getWpUser()->data->ID);

        foreach ($heroes as $hero) {
            $item      = new MenuItem($hero->id, $hero->name, 'user');
            $presenter = new MenuItemPresenter($item, $currentTab, $currentId);

            $childrenHtml .= $renderer(
                Template::ADMINSIDEBARITEM,
                $presenter->toTemplateAttributesCharacter($url, $hero->createStep)
            );
        }

        // UL contenant les enfants
        $ul = Html::getBalise('ul', $childrenHtml, [Constant::CST_CLASS => 'nav nav-treeview']);

        // ----- 3) Item parent -----
        $attributes = [
            $isActiveTab ? Bootstrap::CSS_MENU_OPEN : '',
            '#',
            $isActiveTab ? Constant::CST_ACTIVE : '',
            'users',
            'Personnages',
            '',
            $ul,
            '', '',
        ];

        return $renderer(Template::ADMINSIDEBARITEM, $attributes);
    }
}
