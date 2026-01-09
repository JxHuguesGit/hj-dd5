<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Page\PageList;
use src\Presenter\MenuPresenter;
use src\Presenter\ListPresenter\SpeciesListPresenter;
use src\Service\Species\SpecieReader;

class PublicSpecies extends PublicBase
{
    private ?Collection $species = null;

    public function __construct(
        private SpecieReader $speciesQueryService,
        private SpeciesListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->species = $this->speciesQueryService->getSpeciesByParent(0, [Field::NAME=>Constant::CST_ASC]);
        $this->title = 'Les Espèces';
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::SPECIES);
        $viewData = $this->presenter->present($this->species);
        $viewData[Constant::CST_TITLE] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
