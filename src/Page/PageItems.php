<?php
namespace src\Page;

use src\Model\PageElement;

class PageItems
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'items',
            'icon' => 'fa-solid fa-scroll',
            'title' => 'Matériel',
            'description' => "Tout l'équipement dont a besoin un aventurier.",
            'url' => '/items',
            'order' => 50,
            'parent' => 'home',
        ]);
    }
}
