<?php
namespace src\Page\Renderer;

use src\Presenter\ContentBuilder\WeaponDetailContentBuilder;
use src\Presenter\ViewModel\WeaponPageView;
use src\Renderer\TemplateRenderer;
use src\Utils\UrlGenerator;

class PageItemWeapon extends PageDetail
{
    public function __construct(
        TemplateRenderer $renderer,
        private WeaponDetailContentBuilder $contentBuilder
    ) {
        parent::__construct($renderer);
    }

    protected function getEntityUrl(string $slug): string
    {
        return UrlGenerator::item($slug);
    }

    public function render(
        string $menuHtml,
        WeaponPageView $view
    ): string {
        $contentHtml = $this->contentBuilder->build($view);

        return $this->renderContentDetail(
            $menuHtml,
            $contentHtml
        );
    }
}
