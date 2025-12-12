<?php
namespace src\Page;

use src\Model\PageElement;

class PageOrigines
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'origines',
            'icon' => 'fa-solid fa-users',
            'title' => 'Origines',
            'description' => 'Découvrez les origines jouables.',
            'url' => '/origines',
            'order' => 10,
            'parent' => 'home',
        ]);
    }
}

