<?php
namespace src\Controller\Compendium;

use src\Page\PageList;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Service\Domain\SpellService;

class SpellCompendiumHandler implements CompendiumHandlerInterface
{
    public function __construct(
        private SpellService $reader,
        private SpellListPresenter $presenter,
        private PageList $page
    ) {}

    public function render(): string
    {
        $spells = ($this->reader->allSpells())->collection;
        $presentContent = $this->presenter->present($spells);
        return $this->page->renderAdmin('', $presentContent);
    }
}
