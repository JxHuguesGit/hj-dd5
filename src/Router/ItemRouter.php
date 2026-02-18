<?php
namespace src\Router;

use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Factory\Controller\ItemControllerFactory;

class ItemRouter
{
    public function __construct(
        private ItemControllerFactory $factory
    ) {}

    public function match(string $path): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'une catégorie de matériel ---
        if (preg_match(Routes::ITEMS_PATTERN, $path, $matches)) {
            return $this->factory->createCategoryController($matches[1]);
        }

        ////////////////////////////////////////////////////////////
        // --- Gestion d'un matériel individuel ---
        if (preg_match(Routes::ITEM_PATTERN, $path, $matches)) {
            return $this->factory->createDetailController($matches[1]);
        }

        return null;
    }
}
