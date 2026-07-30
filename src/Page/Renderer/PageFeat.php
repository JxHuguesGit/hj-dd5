<?php
namespace src\Page\Renderer;

use src\Utils\UrlGenerator;

class PageFeat extends PageDetail
{
    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::feat($slug);
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
