<?php
namespace src\Controller\Public;

use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Constant\Routes as R;
use src\Constant\Template as T;
use src\Model\PageElement;
use src\Model\PageRegistry;
use src\Presenter\CardPresenter;
use src\Presenter\MenuPresenter;

class PublicItems extends PublicBase
{
    public function __construct()
    {
        $this->title = L::GEAR_TITLE;
    }

    public function getContentPage(): string
    {
        // Récupérer le menu depuis le registry
        $registry = PageRegistry::getInstance();
        $menuHtml = (new MenuPresenter($registry->all(), C::ITEMS))->render();

        $data = [];
        $data[] = new PageElement([
            C::URL => R::ITEMS_PREFIX.'-'.C::ARMOR,
            C::TITLE => L::ARMORS_TITLE,
        ]);
        $data[] = new PageElement([
            C::URL => R::ITEMS_PREFIX.'-'.C::WEAPON,
            C::TITLE => L::WEAPONS_TITLE,
        ]);
        $data[] = new PageElement([
            C::URL => R::ITEMS_PREFIX.'-'.C::TOOL,
            C::TITLE => L::TOOLS_TITLE,
        ]);
        $data[] = new PageElement([
            C::URL => R::ITEMS_PREFIX.'-'.C::GEAR,
            C::TITLE => L::DIVERS,
        ]);

        $cardPresenter = new CardPresenter($data);
        $contentHtml = $cardPresenter->render();

        $contentSection = $this->getRender(T::CATEGORY_PAGE, [$this->getTitle(), $contentHtml, '', '']);

        return $this->getRender(T::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}
