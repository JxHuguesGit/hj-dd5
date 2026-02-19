<?php
namespace src\Controller\Public;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Language;
use src\Page\PageList;
use src\Presenter\ListPresenter\SkillListPresenter;
use src\Presenter\MenuPresenter;
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
        $this->skills = $this->skillReader->allSkills();
        $this->title = Language::LG_SKILLS_TITLE;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::CST_SKILLS);
        $viewData = $this->presenter->present($this->skills);
        return $this->page->render($menu, $this->title, $viewData);
    }
}
