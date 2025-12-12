<?php
namespace src\Page;

use src\Model\PageElement;

class PageHome
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'home',
            'title' => 'Accueil',
            'url' => '/',
            'icon' => 'fa-solid fa-house',
            'description' => '',
            'order' => 0,
            'parent' => null
        ]);
    }
}
