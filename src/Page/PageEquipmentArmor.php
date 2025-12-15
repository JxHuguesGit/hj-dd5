<?php
namespace src\Page;

use src\Model\PageElement;

class PageEquipmentArmor
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'equipments-armor',
            'icon' => 'fa-solid fa-shield-halved',
            'title' => 'Armures',
            'description' => 'Les armures disponibles pour les aventuriers.',
            'url' => '/equipments-armor',
            'order' => 51,
            'parent' => 'equipments',
        ]);
    }
}
