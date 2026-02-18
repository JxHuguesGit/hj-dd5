<?php
namespace src\Router;

use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Factory\Controller\SkillControllerFactory;

class SkillRouter
{
    public function __construct(
        private SkillControllerFactory $factory
    ) {}

    public function match(string $path): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'une compétence ---
        if (!preg_match(Routes::SKILL_PATTERN, $path, $matches)) {
            return null;
        }

        return $this->factory->createDetailController($matches[1]);
    }
}
