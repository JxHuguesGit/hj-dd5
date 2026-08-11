<?php
namespace src\Controller\Admin;

use src\Constant\Template;
use src\Renderer\TemplateRenderer;

final class AdminMapView
{
    public function __construct(
        private TemplateRenderer $renderer,
    ) {}

    public function getContent(
        string $image,
        array $tokens,
    ): string {
        return $this->renderer->render(
            Template::MAP_PAGE_MJ,
            [
                $image,
                json_encode($tokens, JSON_THROW_ON_ERROR),
            ]
        );
    }
}
