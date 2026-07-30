<?php
namespace src\Page;

use src\Collection\Collection;
use src\Constant\Bootstrap as B;
use src\Constant\Template;
use src\Presenter\TableBuilder\TableBuilderInterface;
use src\Presenter\ContentBuilder\ContentBuilderInterface;
use src\Presenter\ContentBuilder\TableContentBuilder;
use src\Renderer\TemplateRenderer;

class PageList
{
    private ContentBuilderInterface $contentBuilder;

    public function __construct(
        private TemplateRenderer $renderer,
        TableBuilderInterface|ContentBuilderInterface $builder
    ) {
        $this->contentBuilder = $builder instanceof TableBuilderInterface
            ? new TableContentBuilder($builder)
            : $builder;
    }

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
        $contentHtml = $this->contentBuilder->build(
            $viewData,
            [B::WITH_MRGNTOP => false]
        );

        // Section centrale (titre + tableau)
        return $this->renderer->render(
            Template::CATEGORY_PAGE,
            [$title, $contentHtml, $toastContent, '']
        );
    }
}
