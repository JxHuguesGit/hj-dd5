<?php
namespace src\Factory\Controller;


use src\Controller\Public\PublicAoe;
use src\Page\Renderer\PageAoe;
use src\Presenter\ContentBuilder\AoeContentBuilder;
use src\Renderer\TemplateRenderer;

class AoeControllerFactory
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}


    public function createController(): PublicAoe
    {
        return new PublicAoe(
            new PageAoe(
                $this->renderer,
                new AoeContentBuilder(),
            )
        );
    }
}
