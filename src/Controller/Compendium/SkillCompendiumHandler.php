<?php
namespace src\Controller\Compendium;

use src\Page\PageList;
use src\Presenter\ListPresenter\SkillListPresenter;
use src\Service\Reader\SkillReader;

class SkillCompendiumHandler implements CompendiumHandlerInterface
{
    public function __construct(
        private SkillReader $reader,
        private SkillListPresenter $presenter,
        private PageList $page
    ) {}

    public function render(): string
    {
        $skills = $this->reader->allSkills();
        $presentContent = $this->presenter->present($skills);
        return $this->page->renderAdmin('', $presentContent);
    }
}
