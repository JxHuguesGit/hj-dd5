<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Template;
use src\Factory\RepositoryFactory;
use src\Model\PageRegistry;
use src\Page\PageSpeciesList;
use src\Presenter\MenuPresenter;
use src\Presenter\SpeciesCardPresenter;
use src\Presenter\SpeciesListPresenter;
use src\Repository\RpgSpecies as RepositoryRpgSpecies;
use src\Service\RpgSpeciesQueryService;

class PublicSpecies extends PublicBase
{
    private ?Collection $species = null;

    public function __construct(
        private RpgSpeciesQueryService $speciesQueryService,
        private SpeciesListPresenter $presenter,
        private PageSpeciesList $page,
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
        $menu = $this->menuPresenter->render('species');
        $viewData = $this->presenter->present($this->species);
        $viewData['title'] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
