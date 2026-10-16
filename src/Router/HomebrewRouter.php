<?php
namespace src\Router;

use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Factory\Controller\HomebrewControllerFactory;

class HomebrewRouter
{
    public function __construct(
        private HomebrewControllerFactory $factory
    ) {}

    public function match(string $path): ?PublicBase
    {
        if (!preg_match(Routes::HOMEBREW_PATTERN, $path)) {
            return null;
        }

        return $this->factory->createController();
    }
}
