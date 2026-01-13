<?php
namespace src\Page;

use src\Constant\Constant;
use src\Constant\Routes;
use src\Model\PageElement;

class PageFeatsCombat
{
    public function getPageElement(): PageElement
    {
        return new PageElement([
            'slug' => 'feats-combat',
            'icon' => 'fa-solid fa-shield-halved',
            'title' => 'Styles de combat',
            'description' => 'Les dons spécifiques aux styles de combat des guerriers.',
            'url' => Routes::FEATS_PREFIX.Constant::COMBAT,
            'order' => 43,
            'parent' => 'feats',
        ]);
    }
}
