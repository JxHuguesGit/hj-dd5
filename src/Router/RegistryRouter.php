<?php
namespace src\Router;

use src\Controller\Public\PublicBase;
use src\Factory\Controller\PublicControllerFactory;
use src\Model\PageRegistry;

class RegistryRouter
{
    public function __construct(
        private PublicControllerFactory $controllerFactory
    ) {}

    public function match(string $path): ?PublicBase
    {
        $registry = PageRegistry::getInstance();
        $pageElement = $registry->get($path);

        if (!$pageElement) {
            return null;
        }

        return $this->controllerFactory->create($pageElement->getSlug());
    }
}
