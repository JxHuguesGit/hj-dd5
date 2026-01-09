<?php
namespace src\Router;

use src\Controller\PublicBase;
use src\Factory\ServiceFactory;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageList;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Presenter\ListPresenter\ToolListPresenter;
use src\Presenter\ListPresenter\WeaponListPresenter;
use src\Presenter\TableBuilder\ArmorTableBuilder;
use src\Presenter\TableBuilder\WeaponTableBuilder;
use src\Presenter\TableBuilder\ToolTableBuilder;

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
                    $factory->getArmorReader(),
                    new ArmorListPresenter(),
                    new PageList(
                        new TemplateRenderer(),
                        new ArmorTableBuilder()
                    ),
                    new MenuPresenter(PageRegistry::getInstance()->all(), 'items')
                ),
                'tool' => new $controllerClass(
                    $factory->getToolReader(),
                    new ToolListPresenter(),
                    new PageList(
                        new TemplateRenderer(),
                        new ToolTableBuilder()
                    ),
                    new MenuPresenter(PageRegistry::getInstance()->all(), 'items')
                ),
                'weapon' => new $controllerClass(
                    $factory->getWeaponReader(),
                    new WeaponListPresenter(),
                    new PageList(
                        new TemplateRenderer(),
                        new WeaponTableBuilder()
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
