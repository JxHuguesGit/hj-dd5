<?php
namespace src\Router;

use src\Constant\Constant;
use src\Controller\PublicBase;
use src\Controller\PublicSkill;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Model\PageRegistry;
use src\Page\PageSkill;
use src\Presenter\Detail\SkillDetailPresenter;
use src\Service\SkillPageService;

class SkillRouter
{
    public function match(string $path, ReaderFactory $factory, ServiceFactory $serviceFactory): ?PublicBase
    {
        ////////////////////////////////////////////////////////////
        // --- Gestion d'une compétence ---
        if (!preg_match('#^skill-(.+)$#', $path, $matches)) {
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
