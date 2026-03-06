<?php
namespace src\Controller\Public;

use src\Constant\{Constant, Language, Routes, Template};
use src\Model\PageElement;
use src\Model\PageRegistry;
use src\Presenter\CardPresenter;
use src\Presenter\MenuPresenter;

class PublicItems extends PublicBase
{
    public function __construct()
    {
        $this->title = 'Le Matériel';
    }

    public function getContentPage(): string
    {
        // Récupérer le menu depuis le registry
        $registry = PageRegistry::getInstance();
        $menuHtml = (new MenuPresenter($registry->all(), C::ITEMS))->render();

        $data = [];
        $data[] = new PageElement([
            'url' => Routes::ITEMS_PREFIX.'-'.C::ARMOR,
            C::TITLE => L::ARMORS_TITLE,
        ]);
        $data[] = new PageElement([
            'url' => Routes::ITEMS_PREFIX.'-'.C::WEAPON,
            C::TITLE => L::WEAPONS_TITLE,
        ]);
        $data[] = new PageElement([
            'url' => Routes::ITEMS_PREFIX.'-'.C::TOOL,
            C::TITLE => L::TOOLS_TITLE,
        ]);
        $data[] = new PageElement([
            'url' => Routes::ITEMS_PREFIX.'-'.C::GEAR,
            C::TITLE => L::DIVERS,
        ]);

        $cardPresenter = new CardPresenter($data);
        $contentHtml = $cardPresenter->render();

        $contentSection = $this->getRender(Template::CATEGORY_PAGE, [$this->getTitle(), $contentHtml]);

        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}
