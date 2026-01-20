<?php
namespace src\Controller\Public;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Page\PageList;
use src\Presenter\MenuPresenter;
use src\Presenter\ListPresenter\SpellListPresenter;
use src\Service\Domain\SpellService;

class PublicSpells extends PublicBase
{
    private ?Collection $spells = null;

    public function __construct(
        private SpellService $spellService,
        private SpellListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->spells = $this->spellService->allSpells();
        $this->title = 'Les Sorts';
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::SPELLS);
        $viewData = $this->presenter->present($this->spells);
        return $this->page->render($menu, $this->title, $viewData);
    }
}
