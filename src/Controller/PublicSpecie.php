<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Domain\Specie as DomainSpecies;
use src\Page\PageSpecie;
use src\Presenter\MenuPresenter;
use src\Service\Reader\SpecieReader;
use src\Service\SpeciePageService;
use src\Presenter\Detail\SpeciesDetailPresenter;

class PublicSpecie extends PublicBase
{
    private ?DomainSpecies $species;

    public function __construct(
        private string $slug,
        private SpecieReader $specieReader,
        private SpeciePageService $pageService,
        private SpeciesDetailPresenter $presenter,
        private PageSpecie $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->species = $this->specieReader->speciesBySlug($this->slug);
        $this->title = $this->species->name;
    }
    
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::SPECIES);
        $pageView = $this->pageService->build($this->species);
        $viewData = $this->presenter->present($pageView);
        $viewData[Constant::CST_TITLE] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
