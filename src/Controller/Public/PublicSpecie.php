<?php
namespace src\Controller\Public;

use src\Constant\Constant;
use src\Domain\Entity\Specie;
use src\Page\Renderer\PageSpecie;
use src\Presenter\Detail\SpeciesDetailPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Page\SpeciePageService;
use src\Service\Reader\SpecieReader;

class PublicSpecie extends PublicBase
{
    private ?Specie $species;

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

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::SPECIES);
        $pageView = $this->pageService->build($this->species);
        $viewData = $this->presenter->present($pageView);
        $viewData[Constant::CST_TITLE] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
