<?php
namespace src\Page;

use src\Model\PageElement;

class PageFeatsOrigin
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'feats-origin',
            'icon' => 'fa-solid fa-scroll',
            'title' => 'Dons d\'origine',
            'description' => "Les dons d'origine liés aux historiques de personnage.",
            'url' => '/feats-origin',
            'order' => 41,
            'parent' => 'feats',
        ]);
    }
}
