<?php

namespace src\Controller\Public;

use src\Collection\Collection;
use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Constant\Routes as R;
use src\Model\PageRegistry;
use src\Page\PageList;
use src\Presenter\ContentBuilder\ItemCategoryContentBuilder;
use src\Presenter\MenuPresenter;
use src\Presenter\ViewModel\ItemCategory;
use src\Renderer\TemplateRenderer;

class PublicItems extends PublicBase
{
    private Collection $categories;

    public function __construct(
        private PageList $page,
        private MenuPresenter $menuPresenter,
    ) {
        $this->categories = new Collection([
            new ItemCategory(
                title: L::ARMORS_TITLE,
                url: R::ITEMS_PREFIX . '-' . C::ARMOR,
            ),
            new ItemCategory(
                title: L::WEAPONS_TITLE,
                url: R::ITEMS_PREFIX . '-' . C::WEAPON,
            ),
            new ItemCategory(
                title: L::TOOLS_TITLE,
                url: R::ITEMS_PREFIX . '-' . C::TOOL,
            ),
            new ItemCategory(
                title: L::DIVERS,
                url: R::ITEMS_PREFIX . '-' . C::GEAR,
            ),
        ]);

        $this->title = L::GEAR_TITLE;
    }

    public function getContentPage(): string
    {
        $menu = $this->menuPresenter->render();

        return $this->page->render(
            $menu,
            $this->getTitle(),
            $this->categories
        );
    }
}
