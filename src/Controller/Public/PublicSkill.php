<?php
namespace src\Controller\Public;

use src\Constant\Constant;
use src\Domain\Entity\Skill;
use src\Page\PageSkill;
use src\Presenter\MenuPresenter;
use src\Service\Page\SkillPageService;
use src\Presenter\Detail\SkillDetailPresenter;
use src\Service\Reader\SkillReader;

class PublicSkill extends PublicBase
{
    private ?Skill $skill;

    public function __construct(
        private string $slug,
        private SkillReader $skillReader,
        private SkillPageService $pageService,
        private SkillDetailPresenter $presenter,
        private PageSkill $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->skill = $this->skillReader->skillBySlug($this->slug);
        $this->title = $this->skill->name;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::SKILLS);
        $pageView = $this->pageService->build($this->skill);
        $viewData = $this->presenter->present($pageView);
        return $this->page->render($menu, $viewData);
    }
}
