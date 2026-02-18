<?php
namespace src\Router;

use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Factory\Controller\SpecieControllerFactory;

class SpecieRouter
{
    public function __construct(
        private SpecieControllerFactory $factory
    ) {}

    public function match(string $path): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'une espèce individuelle ---
        if (!preg_match(Routes::SPECIE_PATTERN, $path, $matches)) {
            return null;
        }

        return $this->factory->createDetailController($matches[1]);
    }
}
