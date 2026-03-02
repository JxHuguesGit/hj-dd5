<?php
namespace src\Controller\Compendium;

use src\Page\PageList;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Presenter\Modal\SpellFilterModalPresenter;
use src\Service\Domain\SpellService;

class SpellCompendiumHandler implements CompendiumHandlerInterface
{
    public function __construct(
        private SpellService $reader,
        private SpellListPresenter $presenter,
        private PageList $page,
        private SpellFilterModalPresenter $modalPresenter
    ) {}

    public function render(): string
    {
        $spells         = ($this->reader->allSpells())->collection;
        $presentContent = $this->presenter->present($spells);
        $modalContent   = $this->modalPresenter->render();
        return $this->page->renderAdmin('', $presentContent, $modalContent);
    }
}
