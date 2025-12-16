<?php
namespace src\Controller;

use src\Domain\RpgSpecies;
use src\Page\PageSpecie;
use src\Presenter\MenuPresenter;
use src\Service\RpgSpeciesQueryService;
use src\Presenter\SpeciesDetailPresenter;
use src\Service\RpgSpeciesService;

class PublicSpecie extends PublicBase
{
    private ?RpgSpecies $species;

    public function __construct(
        private string $slug,
        private RpgSpeciesService $speciesService,
        private RpgSpeciesQueryService $speciesQueryService,
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
