<?php
namespace src\Router;

use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Factory\Controller\MapControllerFactory;

class MapRouter
{
    public function __construct(
        private MapControllerFactory $factory
    ) {}

    public function match(string $path): ?PublicBase
    {
        if (!preg_match(Routes::MAP_PATTERN, $path)) {
            return null;
        }

        return $this->factory->createController();
    }
}
