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
            'title' => 'Dons',
            'description' => "Les dons sont des capacités spéciales que votre personnage peut acquérir, offrant des avantages uniques et personnalisant davantage son style de jeu.",
            'url' => '/feats',
            'order' => 20,
            'parent' => 'home',
        ]);
    }
}
