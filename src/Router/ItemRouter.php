<?php
namespace src\Router;

use src\Controller\PublicBase;
use src\Factory\ServiceFactory;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageArmorList;
use src\Page\PageWeaponList;
use src\Presenter\ArmorListPresenter;
use src\Presenter\RpgArmorTableBuilder;
use src\Presenter\RpgWeaponTableBuilder;
use src\Presenter\WeaponListPresenter;

class ItemRouter
{
    public function match(string $path, ServiceFactory $factory): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'une catégorie de matériel ---
        if (!preg_match('#^items-(.+)$#', $path, $matches)) {
            return null;
        }

        $typeSlug = $matches[1];
        $controllerClass = 'src\\Controller\\PublicItem' . ucfirst($typeSlug);
        if (class_exists($controllerClass)) {
            return match($typeSlug) {
                'armor' => new $controllerClass(
                    $factory->getRpgArmorQueryService(),
                    new ArmorListPresenter(),
                    new PageArmorList(
                        new TemplateRenderer(),
                        new RpgArmorTableBuilder()
                    ),
                    new MenuPresenter(PageRegistry::getInstance()->all(), 'items')
                ),
                'weapon' => new $controllerClass(
                    $factory->getRpgWeaponQueryService(),
                    new WeaponListPresenter(),
                    new PageWeaponList(
                        new TemplateRenderer(),
                        new RpgWeaponTableBuilder()
                    ),
                    new MenuPresenter(PageRegistry::getInstance()->all(), 'items')
                ),
                default    => new $controllerClass(),
            };
        } else {
            return null;
        }
    }
}
