<?php
namespace src\Page;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Template;
use src\Presenter\TableBuilder\ToolTableBuilder;
use src\Renderer\TemplateRenderer;

class PageToolList
{
    public function __construct(
        private TemplateRenderer $renderer,
        private ToolTableBuilder $tableBuilder
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
        $tableHtml = $this->tableBuilder->build(
            $viewData[Constant::CST_ITEMS],
            [Bootstrap::CSS_WITH_MRGNTOP => false]
        );

        // Section centrale (titre + tableau)
        return $this->renderer->render(
            Template::CATEGORY_PAGE,
            [$viewData[Constant::CST_TITLE], $tableHtml->display()]
        );
    }
}
