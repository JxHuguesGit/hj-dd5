<?php
namespace src\Router;

use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Factory\Controller\GlossaireControllerFactory;

class GlossaireRouter
{
    public function __construct(
        private GlossaireControllerFactory $factory
    ) {}

    public function match(string $path): ?PublicBase
    {
        if (!preg_match(Routes::GLOSSAIRE_PATTERN, $path)) {
            return null;
        }

        return $this->factory->createController();
    }
}
