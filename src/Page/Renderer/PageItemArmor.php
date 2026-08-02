<?php

namespace src\Page\Renderer;

use src\Presenter\ContentBuilder\ArmorDetailContentBuilder;
use src\Presenter\ViewModel\ArmorPageView;
use src\Renderer\TemplateRenderer;
use src\Utils\UrlGenerator;

class PageItemArmor extends PageDetail
{
    public function __construct(
        TemplateRenderer $renderer,
        private ArmorDetailContentBuilder $contentBuilder
    ) {
        parent::__construct($renderer);
    }

    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::item($slug);
    }

    public function render(
        string $menuHtml,
        ArmorPageView $view
    ): string {
        $contentHtml = $this->contentBuilder->build($view);

        return $this->renderContentDetail(
            $menuHtml,
            $contentHtml
        );
    }
}
