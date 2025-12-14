<?php
namespace src\Page;

use src\Model\PageElement;

class PageFeat
{
    public function getPageElement(array $data): PageElement
    {
        return new PageElement([
            'slug' => 'feat-' . $data['slug'],
            'title' => $data['title'],
            'url' => $data['url'],
            'parent' => 'feats'
        ]);
    }
}
