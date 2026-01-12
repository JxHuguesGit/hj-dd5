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
            'title' => 'Historiques',
            'description' => "L'historique de votre personnage est un ensemble d'éléments disparates qui symbolisent le lieu et l'occupation de votre héros en herbe avant qu'il embrasse la carrière d'aventurier.",
            'url' => '/origines',
            'order' => 40,
            'parent' => 'home',
        ]);
    }
}

