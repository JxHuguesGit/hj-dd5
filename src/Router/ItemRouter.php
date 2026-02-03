<?php
namespace src\Router;

use src\Constant\Constant;
use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicItemArmor;
use src\Controller\Public\PublicItemGear;
use src\Controller\Public\PublicItemTool;
use src\Controller\Public\PublicItemWeapon;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageList;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Presenter\ListPresenter\GearListPresenter;
use src\Presenter\ListPresenter\ToolListPresenter;
use src\Presenter\ListPresenter\WeaponListPresenter;
use src\Presenter\TableBuilder\ArmorTableBuilder;
use src\Presenter\TableBuilder\ItemTableBuilder;
use src\Presenter\TableBuilder\WeaponTableBuilder;
use src\Presenter\TableBuilder\ToolTableBuilder;

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
        if (!preg_match(Routes::ITEMS_PATTERN, $path, $matches)) {
            return null;
        }

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
