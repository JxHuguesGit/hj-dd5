<?php
namespace src\Page;

use src\Constant\Constant;
use src\Constant\Routes;
use src\Model\PageElement;

class PageFeatsGeneral
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'feats-general',
            'icon' => 'fa-solid fa-scroll',
            'title' => 'Dons généraux',
            'description' => "Les dons accessibles au cours de la carrière d'un personnage.",
            'url' => Routes::FEAT_PREFIX.'-'.Constant::GENERAL,
            'order' => 42,
            'parent' => 'feats',
        ]);
    }
}
