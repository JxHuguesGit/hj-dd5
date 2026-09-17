<?php
namespace src\Controller\Public;

use src\Collection\Collection;
use src\Constant\Language as L;
use src\Domain\Criteria\FeatCriteria;
use src\Page\PageList;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Reader\FeatReader;
use src\Service\Reader\FeatTypeReader;

class PublicFeatCategory extends PublicBase
{
    private Collection $feats;

    public function __construct(
        private FeatReader $featReader,
        private FeatTypeReader $featTypeReader,
        private FeatListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
        private FeatCriteria $criteria
    ) {
        $this->feats = $this->featReader->allPublishedFeatsWithRelations($this->criteria);
        $this->title = 'Dons : ' . $this->featTypeReader->featTypeById($this->criteria->featTypeId)->name;
    }

    public function getContentPage(): string
    {
        $menu     = $this->menuPresenter->render();
        $viewData = $this->presenter->present($this->feats);
        return $this->page->render($menu, $this->title, $viewData);
    }
}
