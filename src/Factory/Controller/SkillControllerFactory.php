<?php
namespace src\Factory\Controller;

use src\Constant\Constant;
use src\Controller\Public\PublicSkill;
use src\Factory\{ReaderFactory, ServiceFactory};
use src\Model\PageRegistry;
use src\Page\PageSkill;
use src\Presenter\Detail\SkillDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Renderer\TemplateRenderer;
use src\Service\Page\SkillPageService;

class SkillControllerFactory
{
    public function __construct(
        private ReaderFactory $readerFactory,
        private ServiceFactory $serviceFactory,
        private TemplateRenderer $renderer
    ) {}

    public function createDetailController(string $slug): PublicSkill
    {
        $skillReader = $this->readerFactory->skill();
        return new PublicSkill(
            $slug,
            $skillReader,
            new SkillPageService(
                $this->serviceFactory->skill(),
                $skillReader,
                $this->readerFactory->ability(),
                $this->readerFactory->origin()
            ),
            new SkillDetailPresenter(),
            new PageSkill($this->renderer),
            new MenuPresenter(PageRegistry::getInstance()->all(), Constant::SKILLS)
        );
    }
}
