<?php
namespace src\Page;

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
            'url' => '/feats-combat',
            'order' => 43,
            'parent' => 'feats',
        ]);
    }
}
