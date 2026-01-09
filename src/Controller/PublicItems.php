<?php
namespace src\Controller;

use src\Constant\Template;
use src\Model\PageRegistry;
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

        $data = [
            [
                'url' => '/items-armor',
                'title' => 'Armures',
                'description' => '',
                'icon' => '',
                'image' => '',
            ],
            [
                'url' => '/items-weapon',
                'title' => 'Armes',
                'description' => '',
                'icon' => '',
                'image' => '',
            ],
            [
                'url' => '/items-tool',
                'title' => 'Outils',
                'description' => '',
                'icon' => '',
                'image' => '',
            ]
        ];

        $cardPresenter = new OrigineCardPresenter($data);
        $contentHtml = $cardPresenter->render();

        $contentSection = $this->getRender(Template::CATEGORY_PAGE, [$this->getTitle(), $contentHtml]);
        
        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $contentSection]);
    }
}
