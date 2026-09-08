<?php
namespace src\Controller\Public;

use src\Constant\Template;
use src\Page\Renderer\PageInitiative;


class PublicInitiative extends PublicBase
{
    public function __construct(
        private PageInitiative $page
    ) {
        $this->title = 'Initiative';
    }

    public function getContentPage(): string
    {
        return $this->page->render();
    }

    public function getBaseTemplate(): string
    {
        return Template::BASE_INITIATIVE;
    }
}
