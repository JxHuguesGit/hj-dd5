<?php
namespace src\Page;

use src\Model\PageElement;

class PageItemArmor
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'items-armor',
            'icon' => 'fa-solid fa-shield-halved',
            'title' => 'Armures',
            'description' => 'Les armures disponibles pour les aventuriers.',
            'url' => '/items-armor',
            'order' => 51,
            'parent' => 'items',
        ]);
    }
}
