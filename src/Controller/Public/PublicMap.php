<?php
namespace src\Controller\Public;

use src\Constant\Template;
use src\Page\Renderer\PageMap;
use src\Utils\Session;


class PublicMap extends PublicBase
{
    public function __construct(
        private PageMap $page
    ) {
        $this->title = 'Map';
    }

    public function getContentPage(): string
    {
        return $this->page->render(
            Session::getWpUser()->data->ID !== '0'
        );
    }

    public function getBaseTemplate(): string
    {
        return Template::BASE_MAP;
    }
}