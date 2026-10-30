<?php
namespace src\Router;

use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Factory\Controller\RuleControllerFactory;

class RulesRouter
{
    public function __construct(
        private RuleControllerFactory $factory
    ) {}

    public function match(string $path): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'une règle individuelle ---
        if (preg_match(Routes::RULE_PATTERN, $path, $matches)) {
            return $this->factory->createDetailController($matches[1], $matches[2]);
        }

        ////////////////////////////////////////////////////////////
        // --- Gestion d'une catégorie de règles ---
        if (preg_match(Routes::RULES_PATTERN, $path, $matches)) {
            return $this->factory->createCategoryController($matches[1]);
        }

        return null;
    }
}
