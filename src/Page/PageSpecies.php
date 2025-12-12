<?php
namespace src\Page;

use src\Model\PageElement;

class PageSpecies
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'species',
            'icon' => 'fa-solid fa-paw',
            'title' => 'Espèces',
            'description' => 'Découvrez les espèces jouables.',
            'url' => '/species',
            'order' => 20,
            'parent' => 'home',
        ]);
    }

}
