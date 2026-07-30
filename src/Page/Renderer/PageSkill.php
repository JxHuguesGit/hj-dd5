<?php
namespace src\Page\Renderer;

use src\Utils\UrlGenerator;

class PageSkill extends PageDetail
{
    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::skill($slug);
    }

    public function render(
        string $menuHtml,
        string $contentHtml
    ): string {
        return $this->renderContentDetail(
            $menuHtml,
            $contentHtml
        );
    }
}
