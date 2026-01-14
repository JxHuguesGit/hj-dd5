<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Language;
use src\Page\PageList;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Presenter\MenuPresenter;
use src\Service\Reader\ArmorReader;

final class PublicItemArmor extends PublicBase
{
    private ?Collection $armors = null;

    public function __construct(
        private ArmorReader $armorReader,
        private ArmorListPresenter $presenter,
        private PageList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->armors = $this->armorReader->allArmors();
        $this->title = Language::LG_ARMORS_TITLE;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render(Constant::CST_ITEMS);
        $viewData = $this->presenter->present($this->armors);
        $viewData[Constant::CST_TITLE] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
