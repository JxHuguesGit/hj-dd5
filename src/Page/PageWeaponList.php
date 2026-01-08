<?php
namespace src\Page;

use src\Constant\Template;
use src\Presenter\RpgWeaponTableBuilder;
use src\Renderer\TemplateRenderer;

class PageWeaponList
{
    public function __construct(
        private TemplateRenderer $renderer,
        private RpgWeaponTableBuilder $tableBuilder
    ) {}

    public function render(string $menuHtml, array $viewData): string
    {
        // Page complète avec menu
        return $this->renderer->render(
            Template::MAIN_PAGE,
            [$menuHtml, $this->renderAdmin($viewData)]
        );
    }

    public function renderAdmin(array $viewData): string
    {
        // Construire le tableau des origines
        $tableHtml = $this->tableBuilder->build($viewData['items'], ['withMarginTop' => false]);

        // Section centrale (titre + tableau)
        return $this->renderer->render(
            Template::CATEGORY_PAGE,
            [$viewData['title'], $tableHtml->display()]
        );
    }
}
