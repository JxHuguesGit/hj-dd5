<?php
namespace src\Page;

use src\Constant\Constant;
use src\Constant\Routes;
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
            'url' => Routes::FEAT_PREFIX.'-'.Constant::ORIGIN,
            'order' => 41,
            'parent' => 'feats',
        ]);
    }
}
