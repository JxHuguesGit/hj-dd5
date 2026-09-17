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
        ////////////////////////////////////////////////////////////
        // --- Vérification de l'existence ---
        $skillReader = $this->factory->getReaderFactory()->skill();
        $skill = $skillReader->skillBySlug($matches[1]);
        if ($skill === null) {
            return null;
        }

        return $this->factory->createDetailController($skill);
    }
}
