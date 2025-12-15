<?php
namespace src\Page;

use src\Constant\Template;
use src\Presenter\RpgOriginTableBuilder;
use src\Renderer\TemplateRenderer;

class PageOriginList
{
    public function __construct(
        private TemplateRenderer $renderer,
        private RpgOriginTableBuilder $tableBuilder
    ) {}

    public function render(string $menuHtml, array $viewData): string
    {
        // Construire le tableau des origines
        $tableHtml = $this->tableBuilder->build($viewData['origins'], ['withMarginTop' => false]);

        // Section centrale (titre + tableau)
        $contentSection = $this->renderer->render(
            Template::CATEGORY_PAGE,
            [$viewData['title'], $tableHtml->display()]
        );

        // Page complète avec menu
        return $this->renderer->render(
            Template::MAIN_PAGE,
            [$menuHtml, $contentSection]
        );
    }
}
