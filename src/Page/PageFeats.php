<?php
namespace src\Page;

use src\Model\PageElement;

class PageFeats
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'feats',
            'icon' => 'fa-solid fa-scroll',
            'title' => 'Aptitudes',
            'description' => 'Découvrez les dons jouables.',
            'url' => '/feats',
            'order' => 40,
        ]);
    }

    // Ici tu pourrais avoir d'autres méthodes pour rendre la page, etc.
}
