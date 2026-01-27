<?php
namespace src\Page;

use src\Collection\Collection;
use src\Constant\Bootstrap;
use src\Constant\Template;
use src\Presenter\TableBuilder\TableBuilderInterface;
use src\Renderer\TemplateRenderer;

class PageList
{
    public function __construct(
        private TemplateRenderer $renderer,
        private TableBuilderInterface $tableBuilder
    ) {}

    public function render(string $menuHtml, string $title, Collection $viewData, ?string $modalContent = null): string
    {
        // Page complète avec menu
        return $this->renderer->render(
            Template::MAIN_PAGE,
            [$menuHtml, $this->renderAdmin($title, $viewData), $modalContent]
        );
    }

    public function renderAdmin(string $title, Collection $viewData): string
    {
        // Construire le tableau des armures
        $tableHtml = $this->tableBuilder->build(
            $viewData,
            [Bootstrap::CSS_WITH_MRGNTOP => false]
        );

        // Section centrale (titre + tableau)
        return $this->renderer->render(
            Template::CATEGORY_PAGE,
            [$title, $tableHtml->display()]
        );
    }
}
