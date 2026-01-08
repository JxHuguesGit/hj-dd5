<?php
namespace src\Page;

use src\Constant\Template;
use src\Presenter\RpgSkillTableBuilder;
use src\Renderer\TemplateRenderer;

class PageSkillList
{
    public function __construct(
        private TemplateRenderer $renderer,
        private RpgSkillTableBuilder $tableBuilder
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
        // Construire le tableau des compétences
        $tableHtml = $this->tableBuilder->build($viewData['skills'], ['withMarginTop' => false]);

        // Section centrale (titre + tableau)
        return $this->renderer->render(
            Template::CATEGORY_PAGE,
            [$viewData['title'], $tableHtml->display()]
        );
    }
}
