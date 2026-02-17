<?php
namespace src\Router;

use src\Factory\PublicControllerFactory;
use src\Model\PageRegistry;
use src\Controller\Public\PublicBase;

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
