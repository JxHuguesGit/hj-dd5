<?php
namespace src\Router;

use src\Constant\Constant;
use src\Controller\Public\PublicBase;
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
    public function match(string $path, ReaderFactory $factory, ServiceFactory $serviceFactory): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'une catégorie de matériel ---
        if (!preg_match('#^items-(.+)$#', $path, $matches)) {
            return null;
        }

        $typeSlug = $matches[1];
        $controllerClass = 'src\\Controller\\Public\\PublicItem' . ucfirst($typeSlug);
        if (class_exists($controllerClass)) {
            return match($typeSlug) {
                Constant::CST_ARMOR => new $controllerClass(
                    $factory->armor(),
                    new ArmorListPresenter(),
                    new PageList(
                        new TemplateRenderer(),
                        new ArmorTableBuilder()
                    ),
                    new MenuPresenter(PageRegistry::getInstance()->all(), Constant::CST_ITEMS)
                ),
                Constant::CST_TOOL => new $controllerClass(
                    $factory->tool(),
                    new ToolListPresenter(),
                    new PageList(
                        new TemplateRenderer(),
                        new ToolTableBuilder()
                    ),
                    new MenuPresenter(PageRegistry::getInstance()->all(), Constant::CST_ITEMS)
                ),
                Constant::CST_WEAPON => new $controllerClass(
                    $factory->weapon(),
                    new WeaponListPresenter(
                        $serviceFactory->wordPress(),
                        $serviceFactory->weaponProperties(),
                        $factory->weaponPropertyValue()
                    ),
                    new PageList(
                        new TemplateRenderer(),
                        new WeaponTableBuilder()
                    ),
                    new MenuPresenter(PageRegistry::getInstance()->all(), Constant::CST_ITEMS)
                ),
                Constant::CST_GEAR => new $controllerClass(
                    $factory->item(),
                    new GearListPresenter(),
                    new PageList(
                        new TemplateRenderer(),
                        new ItemTableBuilder()
                    ),
                    new MenuPresenter(PageRegistry::getInstance()->all(), Constant::CST_ITEMS)
                ),
                default    => new $controllerClass(),
            };
        } else {
            return null;
        }
    }
}
