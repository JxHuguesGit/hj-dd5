<?php
namespace src\Page;

use src\Constant\Template;
use src\Presenter\RpgSpeciesTableBuilder;
use src\Renderer\TemplateRenderer;

class PageSpeciesList
{
    public function __construct(
        private TemplateRenderer $renderer,
        private RpgSpeciesTableBuilder $tableBuilder
    ) {}

    public function render(string $menuHtml, array $viewData): string
    {
        // Construire le tableau des espèces
        $tableHtml = $this->tableBuilder->build($viewData['species'], ['withMarginTop' => false]);

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
