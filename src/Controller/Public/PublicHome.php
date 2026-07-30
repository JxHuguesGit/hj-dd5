<?php
namespace src\Controller\Public;

use src\Constant\Constant as C;
use src\Constant\Template as T;
use src\Model\PageRegistry;
use src\Presenter\CardPresenter;
use src\Presenter\MenuPresenter;
use src\Utils\Html;

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
        $contentGrid = Html::getDiv($cardPresenter->render(), [C::CSSCLASS => 'card-grid']);
        
        $sectionGrid = $this->getRender(T::HOME_PAGE, [$contentGrid]);
        
        // Ici on renvoie le template de la home
        return $this->getRender(T::MAIN_PAGE, [$menuHtml, $sectionGrid]);
    }
}

