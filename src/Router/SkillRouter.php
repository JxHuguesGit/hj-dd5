<?php
namespace src\Router;

use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;

class SkillRouter
{
    public function __construct(
        private ReaderFactory $factory,
        private ServiceFactory $serviceFactory
    ) {}

    public function match(string $path): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'une compétence ---
        if (!preg_match(Routes::SKILL_PATTERN, $path, $matches)) {
            return null;
        }
        return null;
        /*
        return new PublicSkill(
            $matches[1] ?? '',
            $factory->skill(),
            new SkillPageService($serviceFactory->skill(), $factory->skill()),
            new SkillDetailPresenter(),
            new PageSkill(new TemplateRenderer()),
            new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SKILLS),
        );
        */
    }
}
