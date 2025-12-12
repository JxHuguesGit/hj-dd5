<?php
namespace src\Page;

use src\Model\PageElement;

class PageSpells
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'spells',
            'icon' => 'fa-solid fa-spell-sparkles',
            'title' => 'Sorts',
            'description' => 'Découvrez les sorts jouables.',
            'url' => '/spells',
            'order' => 50,
        ]);
    }

    // Ici tu pourrais avoir d'autres méthodes pour rendre la page, etc.
}
