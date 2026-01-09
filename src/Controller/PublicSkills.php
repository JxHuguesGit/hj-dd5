<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Page\PageList;
use src\Presenter\MenuPresenter;
use src\Presenter\ListPresenter\SkillListPresenter;
use src\Service\Reader\SkillReader;

class PublicSkills extends PublicBase
{
    private ?Collection $skills = null;

    public function __construct(
        private SkillReader $skillReader,
        private SkillListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->skills = $this->skillReader->getAllSkills([Field::ABILITYID=>Constant::CST_ASC, Field::NAME=>Constant::CST_ASC]);
        $this->title = Language::LG_SKILLS_TITLE;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::CST_SKILLS);
        $viewData = $this->presenter->present($this->skills);
        $viewData[Constant::CST_TITLE] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
