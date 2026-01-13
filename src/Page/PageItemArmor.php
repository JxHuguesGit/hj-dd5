<?php
namespace src\Page;

use src\Constant\Constant;
use src\Constant\Routes;
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
            'url' => Routes::ITEMS_PREFIX.Constant::CST_ARMOR,
            'order' => 51,
            'parent' => 'items',
        ]);
    }
}
