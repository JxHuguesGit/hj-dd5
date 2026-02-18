<?php
namespace src\Router;

use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Factory\Controller\OriginControllerFactory;

class OriginRouter
{
    public function __construct(
        private OriginControllerFactory $factory
    ) {}

    public function match(string $path): ?PublicBase
    {
        if (!preg_match(Routes::ORIGIN_PATTERN, $path, $matches)) {
            return null;
        }

        return $this->factory->createDetailController($matches[1]);
    }
}
