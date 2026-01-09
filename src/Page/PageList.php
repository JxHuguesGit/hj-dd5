<?php
namespace src\Page;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Template;
use src\Presenter\TableBuilder\ArmorTableBuilder;
use src\Presenter\TableBuilder\TableBuilderInterface;
use src\Renderer\TemplateRenderer;

class PageList
{
    public function __construct(
        private TemplateRenderer $renderer,
        private TableBuilderInterface $tableBuilder
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
        // Construire le tableau des armures
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
