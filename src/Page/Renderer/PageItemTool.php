<?php
namespace src\Page\Renderer;

use src\Presenter\ContentBuilder\ToolDetailContentBuilder;
use src\Presenter\ViewModel\ToolPageView;
use src\Renderer\TemplateRenderer;
use src\Utils\UrlGenerator;

class PageItemTool extends PageDetail
{
    public function __construct(
        TemplateRenderer $renderer,
        private ToolDetailContentBuilder $contentBuilder
    ) {
        parent::__construct($renderer);
    }

    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::item($slug);
    }

    public function render(
        string $menuHtml,
        ToolPageView $view
    ): string {
        $contentHtml = $this->contentBuilder->build($view);

        return $this->renderContentDetail(
            $menuHtml,
            $contentHtml
        );
    }
}
