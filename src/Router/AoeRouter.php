<?php
namespace src\Router;

use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Factory\Controller\AoeControllerFactory;

class AoeRouter
{
    public function __construct(
        private AoeControllerFactory $factory
    ) {}

    public function match(string $path): ?PublicBase
    {
        if (!preg_match(Routes::AOE_PATTERN, $path)) {
            return null;
        }

        return $this->factory->createController();
    }
}
