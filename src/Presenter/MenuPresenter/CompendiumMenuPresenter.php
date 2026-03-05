<?php
namespace src\Presenter\MenuPresenter;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Constant;
use src\Constant\Icon as I;
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
            ->add(new MenuItem(Constant::WEAPONS, Language::LG_WEAPONS_TITLE, I::GAVEL))
            ->add(new MenuItem(Constant::ARMORS, Language::LG_ARMORS_TITLE, I::SHIELD))
            ->add(new MenuItem(Constant::SKILLS, Language::LG_SKILLS_TITLE, I::BRAIN))
            ->add(new MenuItem(Constant::FEATS, Language::LG_FEATS_TITLE, I::MEDAL))
            ->add(new MenuItem(Constant::CST_GEAR, Language::LG_GEAR_TITLE, I::BOX))
            ->add(new MenuItem(Constant::MONSTERS, Language::LG_MONSTERS_TITLE, I::DRAGON))
            ->add(new MenuItem(Constant::ORIGINS, Language::LG_HISTO_TITLE, I::COMPASS))
            ->add(new MenuItem(Constant::TOOLS, Language::LG_TOOLS_TITLE, I::GAVEL))
            ->add(new MenuItem(Constant::SPELLS, Language::LG_SPELLS_TITLE, I::SCROLL))
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
            [Constant::CST_CLASS => implode(' ', [B::NAV, B::NAV_TREEVIEW])]
        );

        // ---------- 3) Item parent ----------
        $parentAttributes = [
            $isActiveTab ? B::MENU_OPEN : '',
            '#',
            $isActiveTab ? Constant::CST_ACTIVE : '',
            I::BOOK,
            Language::LG_COMPENDIUM,
            '',
            $ul,
            '',
            '',
        ];

        return $renderer(Template::ADMINSIDEBARITEM, $parentAttributes);
    }
}
