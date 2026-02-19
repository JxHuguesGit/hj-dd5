<?php
namespace src\Controller\Public;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Page\PageList;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Reader\FeatReader;

class PublicFeats extends PublicBase
{
    private Collection $feats;

    public function __construct(
        private FeatReader $featReader,
        private FeatListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->feats = $this->featReader->allFeats();
        $this->title = Language::LG_FEATS_TITLE;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::FEATS);
        $viewData = $this->presenter->present($this->feats);
        return $this->page->render($menu, $this->title, $viewData);
    }
}
