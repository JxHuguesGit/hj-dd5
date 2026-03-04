<?php
namespace src\Presenter\MenuPresenter;

use src\Collection\Collection;
use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Icon;
use src\Constant\Language;
use src\Constant\Template;
use src\Presenter\ViewModel\MenuItem;
use src\Utils\Html;

class CompendiumMenuPresenter
{
    public function render(string $currentTab, string $currentId, callable $renderer): string
    {
        $isActiveTab = ($currentTab === Constant::ONG_COMPENDIUM);

        // ---------- 1) Définition des items ----------
        $children = new Collection();
        $children
            ->add(new MenuItem(Constant::WEAPONS, Language::LG_WEAPONS_TITLE, Icon::IGAVEL))
            ->add(new MenuItem(Constant::ARMORS, Language::LG_ARMORS_TITLE, Icon::ISHIELD))
            ->add(new MenuItem(Constant::SKILLS, Language::LG_SKILLS_TITLE, Icon::IBRAIN))
            ->add(new MenuItem(Constant::FEATS, Language::LG_FEATS_TITLE, Icon::IMEDAL))
            ->add(new MenuItem(Constant::CST_GEAR, Language::LG_GEAR_TITLE, Icon::IBOX))
            ->add(new MenuItem(Constant::MONSTERS, Language::LG_MONSTERS_TITLE, Icon::IDRAGON))
            ->add(new MenuItem(Constant::ORIGINS, Language::LG_HISTO_TITLE, Icon::ICOMPASS))
            ->add(new MenuItem(Constant::TOOLS, Language::LG_TOOLS_TITLE, Icon::IGAVEL))
            ->add(new MenuItem(Constant::SPELLS, Language::LG_SPELLS_TITLE, Icon::ISCROLL))
        ;

        // ---------- 2) Construction des enfants ----------
        $childrenHtml = '';
        foreach ($children as $child) {
            $presenter = new MenuItemPresenter($child, $currentTab, $currentId);

            $childrenHtml .= $renderer(
                Template::ADMINSIDEBARITEM,
                $presenter->toTemplateAttributesCompendium()
            );
        }

        $ul = Html::getUl(
            $childrenHtml,
            [Constant::CST_CLASS => implode(' ', [Bootstrap::CSS_NAV, Bootstrap::CSS_NAV_TREEVIEW])]
        );

        // ---------- 3) Item parent ----------
        $parentAttributes = [
            $isActiveTab ? Bootstrap::CSS_MENU_OPEN : '',
            '#',
            $isActiveTab ? Constant::CST_ACTIVE : '',
            Icon::IBOOK,
            Language::LG_COMPENDIUM,
            '',
            $ul,
            '',
            '',
        ];

        return $renderer(Template::ADMINSIDEBARITEM, $parentAttributes);
    }
}
