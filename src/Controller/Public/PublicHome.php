<?php
namespace src\Controller\Public;

use src\Constant\Template;
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
        $menuHtml = (new MenuPresenter($registry->all()))->render();

        $pages = array_filter(
            $registry->all(),
            fn($el) => $el->getSlug() !== 'home' && $el->getParentSlug() === 'home'
        );

        $cardPresenter = new CardPresenter($pages);
        $contentGrid = $cardPresenter->render();
        
        $sectionGrid = $this->getRender(Template::HOME_PAGE, [$contentGrid]);
        
        // Ici on renvoie le template de la home
        return $this->getRender(Template::MAIN_PAGE, [$menuHtml, $sectionGrid]);
    }
}

