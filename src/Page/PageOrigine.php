<?php
namespace src\Page;

use src\Model\PageElement;

class PageOrigine
{
    public function getPageElement(array $data): PageElement
    {
        return new PageElement([
            'slug' => 'origine-' . $data['slug'],
            'title' => $data['title'],
            'url' => $data['url'],
            'parent' => 'origines'
        ]);
    }
}

