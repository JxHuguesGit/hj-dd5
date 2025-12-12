<?php
namespace src\Page;

use src\Model\PageElement;

class PageRules
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'rules',
            'icon' => 'fa-solid fa-book',
            'title' => 'Règles',
            'description' => 'Découvrez les règles du jeu.',
            'url' => '/rules',
            'order' => 70,
        ]);
    }

    // Ici tu pourrais avoir d'autres méthodes pour rendre la page, etc.
}
