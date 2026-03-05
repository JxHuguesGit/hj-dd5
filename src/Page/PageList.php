<?php
namespace src\Page;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Template;
use src\Presenter\TableBuilder\TableBuilderInterface;
use src\Renderer\TemplateRenderer;

class PageList
{
    public function __construct(
        private TemplateRenderer $renderer,
        private TableBuilderInterface $tableBuilder
    ) {}

    public function render(string $menuHtml, string $title, Collection $viewData): string
    {
        // Page complète avec menu
        return $this->renderer->render(
            Template::MAIN_PAGE,
            [$menuHtml, $this->renderAdmin($title, $viewData), '']
        );
    }

    public function renderAdmin(string $title, Collection $viewData, ?string $toastContent = null): string
    {
        // Construire le tableau
        $tableHtml = $this->tableBuilder->build(
            $viewData,
            [B::WITH_MRGNTOP => false]
        );

        // Section centrale (titre + tableau)
        return $this->renderer->render(
            Template::CATEGORY_PAGE,
            [$title, $tableHtml->display(), $toastContent, '']
        );
    }
}
