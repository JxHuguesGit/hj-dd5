<?php
namespace src\Page;

use src\Constant\Template;
use src\Presenter\RpgArmorTableBuilder;
use src\Renderer\TemplateRenderer;

class PageArmorList
{
    public function __construct(
        private TemplateRenderer $renderer,
        private RpgArmorTableBuilder $tableBuilder
    ) {}

    public function render(string $menuHtml, array $viewData): string
    {
        // Construire le tableau des origines
        $tableHtml = $this->tableBuilder->build($viewData['items'], ['withMarginTop' => false]);

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
