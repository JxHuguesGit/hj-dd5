<?php

namespace src\Page\Renderer;

use src\Constant\Template;
use src\Presenter\ContentBuilder\GlossaireContentBuilder;
use src\Renderer\TemplateRenderer;

class PageGlossaire
{
    public function __construct(
        private TemplateRenderer $renderer,
        private GlossaireContentBuilder $contentBuilder
    ) {}

    public function render(): string
    {
        return $this->renderer->render(
            Template::GLOSSAIRE_PAGE,
            [
                $this->contentBuilder->buildHeader(),
                $this->contentBuilder->build(),
            ]
        );
    }
}
