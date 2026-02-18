<?php
namespace src\Router;

use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Factory\Controller\SpellControllerFactory;

class SpellRouter
{
    public function __construct(
        private SpellControllerFactory $factory
    ) {}

    public function match(string $path): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'un sort individuel ---
        if (!preg_match(Routes::SPELL_PATTERN, $path, $matches)) {
            return null;
        }

        return $this->factory->createDetailController($matches[1]);
    }
}
