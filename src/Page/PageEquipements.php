<?php
namespace src\Page;

use src\Model\PageElement;

class PageEquipements
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'equipments',
            'icon' => 'fa-solid fa-scroll',
            'title' => 'Equipement',
            'description' => "Tout l'équipement dont a besoin un aventurier.",
            'url' => '/equipments',
            'order' => 50,
            'parent' => 'home',
        ]);
    }
}
