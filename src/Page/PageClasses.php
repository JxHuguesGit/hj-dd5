<?php
namespace src\Page;

use src\Model\PageElement;

class PageClasses
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'classes',
            'icon' => 'fa-solid fa-shield-halved',
            'title' => 'Classes',
            'description' => 'Découvrez les classes jouables.',
            'url' => '/classes',
            'order' => 30,
        ]);
    }

    // Ici tu pourrais avoir d'autres méthodes pour rendre la page, etc.
}
