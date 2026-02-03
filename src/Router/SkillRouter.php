<?php
namespace src\Router;

use src\Constant\Constant;
use src\Constant\Routes;
use src\Controller\Public\PublicBase;
use src\Controller\Public\PublicSkill;
use src\Factory\ReaderFactory;
use src\Factory\ServiceFactory;
use src\Model\PageRegistry;
use src\Page\PageSkill;
use src\Presenter\Detail\SkillDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Page\SkillPageService;

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

        return new PublicSkill(
            $matches[1] ?? '',
            $this->factory->skill(),
            new SkillPageService(
                $this->serviceFactory->skill(),
                $this->factory->skill(),
                $this->factory->ability()
            ),
            new SkillDetailPresenter(),
            new PageSkill(new TemplateRenderer()),
            new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SKILLS),
        );
    }
}
