<?php
namespace src\Controller;

use src\Domain\Specie as DomainSpecies;
use src\Page\PageSpecie;
use src\Presenter\MenuPresenter;
use src\Service\Species\SpecieReader;
use src\Presenter\SpeciesDetailPresenter;

class PublicSpecie extends PublicBase
{
    private ?DomainSpecies $species;

    public function __construct(
        private string $slug,
        private SpecieReader $speciesQueryService,
        private SpeciesDetailPresenter $presenter,
        private PageSpecie $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->species = $speciesQueryService->getSpeciesBySlugOrFail($this->slug);
        $this->title = $this->species->name;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render('species');
        $nav = $this->speciesQueryService->getPreviousAndNext($this->species);
        $viewData = $this->presenter->present(
            $this->species,
            $nav['prev'],
            $nav['next'],
        );
        $viewData['title'] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
