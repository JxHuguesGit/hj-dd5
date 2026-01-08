<?php
namespace src\Controller;

use src\Constant\Template;
use src\Controller\PublicBase;
use src\Model\PageRegistry;
use src\Presenter\CardPresenter;
use src\Presenter\MenuPresenter;

class PublicHome extends PublicBase
{
    /**
     * Titre de la page
     */
    public function getTitle(): string
    {
        return 'DD5 2024 - Accueil';
    }

    /**
     * Contenu de la page
     */
    public function getContentPage(): string
    {
        $registry = PageRegistry::getInstance();
        
        $menuPresenter = new MenuPresenter($registry->all());
        $pages = array_filter(
            $registry->all(),
            fn($el) => $el->getSlug() !== 'home'
        );
        $pages = array_filter(
            $pages,
            fn($el) => $el->getParentSlug() === 'home'
        );
        $cardPresenter = new CardPresenter($pages);
        
        $mainMenu = $menuPresenter->render();
        $contentGrid = $cardPresenter->render();
        $sectionGrid = $this->getRender(Template::HOME_PAGE, [$contentGrid]);
        
        // Ici on renvoie le template de la home
        return $this->getRender(Template::MAIN_PAGE, [$mainMenu, $sectionGrid]);
    }
}

