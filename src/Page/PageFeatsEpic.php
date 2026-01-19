<?php
namespace src\Page;

use src\Constant\Constant;
use src\Constant\Routes;
use src\Model\PageElement;

class PageFeatsEpic
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'feats-epic',
            'icon' => 'fa-solid fa-star',
            'title' => 'Faveurs épiques',
            'description' => 'Les dons de haut niveau, puissants et rares.',
            'url' => Routes::FEAT_PREFIX.'-'.Constant::EPIC,
            'order' => 44,
            'parent' => 'feats',
        ]);
    }
}
