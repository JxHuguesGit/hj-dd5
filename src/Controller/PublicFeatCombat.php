<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Presenter\MenuPresenter;
use src\Page\PageList;
use src\Presenter\ListPresenter\FeatListPresenter;
use src\Service\Reader\FeatReader;

class PublicFeatCombat extends PublicBase
{
    private Collection $feats;

    public function __construct(
        private FeatReader $featReader,
        private FeatListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->feats = $this->featReader->featsByCategory(3, [Field::NAME=>Constant::CST_ASC]);
        $this->title = Language::LG_CBT_STYLE_FEATS;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::FEATS);
        $viewData = $this->presenter->present($this->feats);
        $viewData[Constant::CST_TITLE] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
