<?php
namespace src\Controller\Public;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Constant\Language;
use src\Page\PageList;
use src\Presenter\MenuPresenter;
use src\Presenter\ListPresenter\OriginListPresenter;
use src\Service\Reader\OriginReader;

class PublicOrigines extends PublicBase
{
    private ?Collection $origins = null;

    public function __construct(
        private OriginReader $originReader,
        private OriginListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->origins = $this->originReader->allOrigins([Field::NAME=>Constant::CST_ASC]);
        $this->title = Language::LG_HISTORIQUES;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::ORIGINS);
        $viewData = $this->presenter->present($this->origins);
        return $this->page->render($menu, $this->title, $viewData);
    }
}

