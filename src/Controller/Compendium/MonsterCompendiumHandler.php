<?php
namespace src\Controller\Compendium;

use src\Page\PageList;
use src\Presenter\ListPresenter\MonsterListPresenter;
use src\Service\Reader\MonsterReader;

class MonsterCompendiumHandler implements CompendiumHandlerInterface
{
    public function __construct (
        private MonsterReader $reader,
        private MonsterListPresenter $presenter,
        private PageList $page,
    ) {}

    public function render(): string
    {
        $monsters = $this->reader->allMonsters();
        $presentContent = $this->presenter->present($monsters);
        return $this->page->renderAdmin('', $presentContent);
    }
}
