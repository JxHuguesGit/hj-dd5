<?php
namespace src\Page;

use src\Model\PageElement;

class PageGear
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'item',
            'icon' => 'fa-solid fa-box-open',
            'title' => 'Équipement',
            'description' => 'Découvrez l\'équipement jouable.',
            'url' => '/item',
            'order' => 50,
        ]);
    }

    // Ici tu pourrais avoir d'autres méthodes pour rendre la page, etc.
}
