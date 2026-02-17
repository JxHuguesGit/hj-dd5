<?php
namespace src\Router;

use src\Factory\FeatControllerFactory;
use src\Controller\Public\PublicBase;
use src\Constant\Routes;

class FeatRouter
{
    public function __construct(
        private FeatControllerFactory $factory
    ) {}

    public function match(string $path): ?PublicBase
    {
        // Catégorie de dons
        if ($slug = $this->matchPattern($path, Routes::FEATS_PATTERN)) {
            return $this->factory->createCategoryController($slug);
        }

        // Don individuel
        if ($slug = $this->matchPattern($path, Routes::FEAT_PATTERN)) {
            return $this->factory->createDetailController($slug);
        }

        return null;
    }

    private function matchPattern(string $path, string $pattern): ?string
    {
        return preg_match($pattern, $path, $matches) ? $matches[1] : null;
    }
}
