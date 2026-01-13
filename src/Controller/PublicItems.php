<?php
namespace src\Controller;

use src\Constant\Constant;
use src\Constant\Routes;
use src\Constant\Template;
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
        $menuHtml = (new MenuPresenter($registry->all(), 'items'))->render();

        $data = [];
        $data[] = new PageElement([
            'url' => Routes::ITEMS_PREFIX.Constant::CST_ARMOR,
            Constant::CST_TITLE => 'Armures',
        ]);
        $data[] = new PageElement([
            'url' => Routes::ITEMS_PREFIX.Constant::CST_WEAPON,
            Constant::CST_TITLE => 'Armes',
        ]);
        $data[] = new PageElement([
            'url' => Routes::ITEMS_PREFIX.Constant::CST_TOOL,
            Constant::CST_TITLE => 'Outils',
        ]);

        $cardPresenter = new CardPresenter($data);
        $contentHtml = $cardPresenter->render();

        $contentSection = $this->getRender(Template::CATEGORY_PAGE, [$this->getTitle(), $contentHtml]);
        
        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}
