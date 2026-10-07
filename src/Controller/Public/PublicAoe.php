<?php
namespace src\Controller\Public;

use src\Constant\Template;
use src\Page\Renderer\PageAoe;


class PublicAoe extends PublicBase
{
    public function __construct(
        private PageAoe $page
    ) {
        $this->title = 'Zones d\'effet';
    }

    public function getContentPage(): string
    {
        return $this->page->render();
    }

    public function getBaseTemplate(): string
    {
        return Template::BASE_AOE;
    }
}
