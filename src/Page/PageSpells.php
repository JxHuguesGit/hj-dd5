<?php
namespace src\Page;

use src\Constant\Routes;
use src\Model\PageElement;

class PageSpells
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'spells',
            'icon' => 'fa-solid fa-spell-sparkles',
            'title' => 'Sorts',
            'description' => 'Les sorts auxquels ont accès les différentes classes.',
            'url' => Routes::SPELLS_PREFIX,
            'order' => 60,
            'parent' => 'home',
        ]);
    }
}
