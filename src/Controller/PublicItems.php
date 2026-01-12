<?php
namespace src\Controller;

use src\Constant\Template;
use src\Model\PageElement;
use src\Model\PageRegistry;
use src\Presenter\CardPresenter;
use src\Presenter\MenuPresenter;
use src\Presenter\OrigineCardPresenter;

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
            'url' => '/feats-armor',
            'title' => 'Armures',
        ]);
        $data[] = new PageElement([
            'url' => '/feats-weapon',
            'title' => 'Armes',
        ]);
        $data[] = new PageElement([
            'url' => '/feats-tool',
            'title' => 'Outils',
        ]);

        $cardPresenter = new CardPresenter($data);
        $contentHtml = $cardPresenter->render();

        $contentSection = $this->getRender(Template::CATEGORY_PAGE, [$this->getTitle(), $contentHtml]);
        
        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}
