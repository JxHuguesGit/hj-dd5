<?php
namespace src\Page\Renderer;

use src\Presenter\ContentBuilder\SpellDetailContentBuilder;
use src\Presenter\ViewModel\SpellPageView;
use src\Renderer\TemplateRenderer;
use src\Utils\UrlGenerator;

class PageSpell extends PageDetail
{
    public function __construct(
        TemplateRenderer $renderer,
        private SpellDetailContentBuilder $contentBuilder
    ) {
        parent::__construct($renderer);
    }

    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::spell($slug);
    }

    public function render(string $menuHtml, SpellPageView $view): string
    {
        $contentHtml = $this->contentBuilder->build($view);

        return $this->renderContentDetail(
            $menuHtml,
            $contentHtml
        );
    }
}
