<?php
namespace src\Controller\Public;

use src\Constant\Constant as C;
use src\Domain\Entity\Skill;
use src\Page\Renderer\PageSkill;
use src\Presenter\ContentBuilder\SkillDetailContentBuilder;
use src\Presenter\Detail\SkillDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Page\SkillPageService;

class PublicSkill extends PublicBase
{
    public function __construct(
        private Skill $skill,
        private SkillPageService $pageService,
        private SkillDetailPresenter $presenter,
        private SkillDetailContentBuilder $contentBuilder,
        private PageSkill $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->title = $this->skill->name;
    }

    public function getTitle(): string
    {
        return $this->title ?? '';
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render();
        if ($this->skill->id === null) {
            return $this->page->render($menu, '');
        }
        $pageView = $this->pageService->build($this->skill);
        $viewData = $this->presenter->present($pageView);
        $contentHtml = $this->contentBuilder->build($viewData);
        return $this->page->render($menu, $contentHtml);
    }
}
