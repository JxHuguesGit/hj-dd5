<?php
namespace src\Page\Renderer;

use src\Presenter\ContentBuilder\GearDetailContentBuilder;
use src\Presenter\ViewModel\GearPageView;
use src\Renderer\TemplateRenderer;
use src\Utils\UrlGenerator;

class PageItemGear extends PageDetail
{
    public function __construct(
        TemplateRenderer $renderer,
        private GearDetailContentBuilder $contentBuilder
    ) {
        parent::__construct($renderer);
    }

    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::item($slug);
    }

    public function render(
        string $menuHtml,
        GearPageView $view
    ): string {
        $contentHtml = $this->contentBuilder->build($view);

        return $this->renderContentDetail(
            $menuHtml,
            $contentHtml
        );
    }
}
