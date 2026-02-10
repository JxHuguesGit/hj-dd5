<?php
namespace src\Router;

use src\Constant\Constant;
use src\Constant\Routes;
use src\Controller\Public\{
    PublicBase,
    PublicItemArmor,
    PublicItemArmorDetail,
    PublicItemGear,
    PublicItemTool,
    PublicItemWeapon,
    PublicItemWeaponDetail
};
use src\Domain\Armor;
use src\Domain\Criteria\ArmorCriteria;
use src\Domain\Criteria\ItemCriteria;
use src\Domain\Item;
use src\Domain\Weapon;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageItemArmor;
use src\Page\PageItemWeapon;
use src\Page\PageList;
use src\Presenter\Detail\ArmorDetailPresenter;
use src\Presenter\Detail\WeaponDetailPresenter;
use src\Presenter\ListPresenter\{ArmorListPresenter, GearListPresenter, ToolListPresenter, WeaponListPresenter};
use src\Presenter\TableBuilder\{ArmorTableBuilder, ItemTableBuilder, ToolTableBuilder, WeaponTableBuilder};
use src\Presenter\ViewModel\ArmorPageView;
use src\Presenter\ViewModel\WeaponPageView;

class ItemRouter
{
    private MenuPresenter $menu;
    private TemplateRenderer $renderer;

    public function __construct(
        private ReaderFactory $factory,
        private ServiceFactory $serviceFactory
    ) {}
    
    public function match(string $path): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'une catégorie de matériel ---
        if (preg_match(Routes::ITEMS_PATTERN, $path, $matches)) {
            $typeSlug = $matches[1];
            $this->menu = new MenuPresenter(PageRegistry::getInstance()->all(), Constant::CST_ITEMS);
            $this->renderer = new TemplateRenderer();

            return match($typeSlug) {
                Constant::CST_ARMOR  => $this->buildArmorController(),
                Constant::CST_TOOL   => $this->buildToolController(),
                Constant::CST_WEAPON => $this->buildWeaponController(),
                Constant::CST_GEAR   => $this->buildGearController(),
                default              => null,
            };
        }

        ////////////////////////////////////////////////////////////
        // --- Gestion d'un matériel individuel ---
        if (preg_match(Routes::ITEM_PATTERN, $path, $matches)) {
            $itemSlug = $matches[1];

            $this->menu = new MenuPresenter(PageRegistry::getInstance()->all(), Constant::CST_ITEMS);
            $this->renderer = new TemplateRenderer();

            $criteria = new ItemCriteria();
            $criteria->type = null;
            $item = $this->factory->item()->itemBySlug($itemSlug, $criteria);

            switch ($item?->type) {
                case Constant::CST_ARMOR :
                    $item = $this->factory->armor()->itemBySlug($itemSlug);
                    return $this->buildArmorDetailController($item);
                    break;
                case Constant::CST_WEAPON :
                    $item = $this->factory->weapon()->itemBySlug($itemSlug);
                    return $this->buildWeaponDetailController($item);
                    break;
                default :
                    return null;
                    break;
            }
        }

        return null;
    }

    private function buildArmorDetailController(Armor $item): ?PublicBase
    {
            if (!$item) {
                return null;
            }

            $nav = $this->factory->armor()->getPreviousAndNext($item);

            $pageView = new ArmorPageView(
                $item,
                $nav[Constant::CST_PREV],
                $nav[Constant::CST_NEXT],
            );
            $presenter = new ArmorDetailPresenter();
            $page = new PageItemArmor(
                new TemplateRenderer()
            );
            return new PublicItemArmorDetail($presenter, $this->menu, $pageView, $page);
    }

    private function buildWeaponDetailController(Weapon $item): ?PublicBase
    {
            if (!$item) {
                return null;
            }

            $nav = $this->factory->weapon()->getPreviousAndNext($item);

            $pageView = new WeaponPageView(
                $item,
                $nav[Constant::CST_PREV],
                $nav[Constant::CST_NEXT],
            );
            $presenter = new WeaponDetailPresenter();
            $page = new PageItemWeapon(
                new TemplateRenderer()
            );
            return new PublicItemWeaponDetail($presenter, $this->menu, $pageView, $page);
    }

    private function buildArmorController(): PublicBase
    {
        return new PublicItemArmor(
            $this->factory->armor(),
            new ArmorListPresenter(),
            new PageList($this->renderer, new ArmorTableBuilder()),
            $this->menu
        );
    }

    private function buildToolController(): PublicBase
    {
        return new PublicItemTool(
            $this->factory->tool(),
            new ToolListPresenter(
                $this->factory->origin()
            ),
            new PageList($this->renderer, new ToolTableBuilder()),
            $this->menu
        );
    }

    private function buildWeaponController(): PublicBase
    {
        return new PublicItemWeapon(
            $this->factory->weapon(),
            new WeaponListPresenter(
                $this->serviceFactory->wordPress(),
                $this->serviceFactory->weaponProperties(),
                $this->factory->weaponPropertyValue()
            ),
            new PageList($this->renderer, new WeaponTableBuilder()),
            $this->menu
        );
    }

    private function buildGearController(): PublicBase {
        return new PublicItemGear(
            $this->factory->item(),
            new GearListPresenter(),
            new PageList($this->renderer, new ItemTableBuilder()),
            $this->menu
        );
    }
}
