<?php

namespace src\Page\Renderer;

use src\Constant\Template;
use src\Presenter\ContentBuilder\AoeContentBuilder;
use src\Renderer\TemplateRenderer;

class PageAoe
{
    public function __construct(
        private TemplateRenderer $renderer,
        private AoeContentBuilder $contentBuilder
    ) {}

    public function render(): string
    {
        return $this->renderer->render(
            Template::AOE_PAGE,
            [
                $this->contentBuilder->buildHeader(),
                $this->contentBuilder->build(),
            ]
        );
    }
}
