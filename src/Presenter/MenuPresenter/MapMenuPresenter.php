<?php
namespace src\Presenter\MenuPresenter;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Icon as I;
use src\Constant\Template;
use src\Presenter\ViewModel\MenuItem;
use src\Utils\Html;

class MapMenuPresenter
{
    public function render(string $currentTab, string $currentId, callable $renderer): string
    {
        $isActiveTab = ($currentTab === C::ONG_MAP);

        // ---------- 1) Définition des items ----------
        $children = new Collection();
        $children
            ->add(new MenuItem(C::MAPS, 'Maps', I::MAP))
            ->add(new MenuItem(C::TOKENS, 'Tokens', I::CIRCLEDOT))
        ;

        // ---------- 2) Construction des enfants ----------
        $childrenHtml = '';
        foreach ($children as $child) {
            $presenter = new MenuItemPresenter($child, $currentTab, $currentId);

            $childrenHtml .= $renderer(
                Template::ADMINSIDEBARITEM,
                $presenter->toTemplateAttributesMap()
            );
        }

        $ul = Html::getUl(
            $childrenHtml,
            [C::CSSCLASS => implode(' ', [B::NAV, B::NAV_TREEVIEW])]
        );

        // ---------- 3) Item parent ----------
        $parentAttributes = [
            $isActiveTab ? B::MENU_OPEN : '',
            '#',
            $isActiveTab ? C::ACTIVE : '',
            I::MAP,
            'Map',
            '',
            $ul,
            '',
            '',
        ];

        return $renderer(Template::ADMINSIDEBARITEM, $parentAttributes);
    }
}
