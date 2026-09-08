<?php
namespace src\Router;

use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Factory\Controller\InitiativeControllerFactory;

class InitiativeRouter
{
    public function __construct(
        private InitiativeControllerFactory $factory
    ) {}

    public function match(string $path): ?PublicBase
    {
        if (!preg_match(Routes::INITIATIVE_PATTERN, $path)) {
            return null;
        }

        return $this->factory->createController();
    }
}
