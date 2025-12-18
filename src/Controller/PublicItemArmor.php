<?php
namespace src\Controller;

use src\Collection\Collection;
use src\Page\PageArmorList;
use src\Presenter\ArmorListPresenter;
use src\Presenter\MenuPresenter;
use src\Service\RpgArmorQueryService;

final class PublicItemArmor extends PublicBase
{
    private ?Collection $armors = null;

    public function __construct(
        private RpgArmorQueryService $armorQueryService,
        private ArmorListPresenter $presenter,
        private PageArmorList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->armors = $this->armorQueryService->getAllArmors();
        $this->title = 'Les Armures';
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render('items');
        $viewData = $this->presenter->present($this->armors);
        $viewData['title'] = $this->getTitle();
        return $this->page->render($menu, $viewData);
    }
}
