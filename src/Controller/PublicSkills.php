<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Page\PageSkillList;
use src\Presenter\MenuPresenter;
use src\Presenter\SkillListPresenter;
use src\Service\RpgSkillQueryService;

class PublicSkills extends PublicBase
{
    private ?Collection $skills = null;

    public function __construct(
        private RpgSkillQueryService $skillQueryService,
        private SkillListPresenter $presenter,
        private PageSkillList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->skills = $this->skillQueryService->getAllSkills([Field::ABILITYID=>Constant::CST_ASC, Field::NAME=>Constant::CST_ASC]);
        $this->title = 'Les Compétences';
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render('skills');
        $viewData = $this->presenter->present($this->skills);
        $viewData['title'] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
