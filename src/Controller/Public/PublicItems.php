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
        $menuHtml = (new MenuPresenter($registry->all(), Constant::CST_ITEMS))->render();

        $data = [];
        $data[] = new PageElement([
            'url' => Routes::ITEMS_PREFIX.'-'.Constant::CST_ARMOR,
            Constant::CST_TITLE => Language::LG_ARMORS_TITLE,
        ]);
        $data[] = new PageElement([
            'url' => Routes::ITEMS_PREFIX.'-'.Constant::CST_WEAPON,
            Constant::CST_TITLE => Language::LG_WEAPONS_TITLE,
        ]);
        $data[] = new PageElement([
            'url' => Routes::ITEMS_PREFIX.'-'.Constant::CST_TOOL,
            Constant::CST_TITLE => Language::LG_TOOLS_TITLE,
        ]);
        $data[] = new PageElement([
            'url' => Routes::ITEMS_PREFIX.'-'.Constant::CST_GEAR,
            Constant::CST_TITLE => Language::LG_DIVERS,
        ]);

        $cardPresenter = new CardPresenter($data);
        $contentHtml = $cardPresenter->render();

        $contentSection = $this->getRender(Template::CATEGORY_PAGE, [$this->getTitle(), $contentHtml]);

        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}
