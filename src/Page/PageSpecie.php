<?php
namespace src\Page;

use src\Constant\Template;
use src\Renderer\TemplateRenderer;

class PageSpecie
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}
    
    public function render(string $menuHtml, array $data): string
    {
        $prevHtml = $data['prev']
            ? sprintf(
                '<a class="btn btn-sm btn-outline-dark" href="/specie-%s">&lt; %s</a>',
                $data['prev']['slug'],
                $data['prev']['name']
            )
            : '<span></span>';

        $nextHtml = $data['next']
            ? sprintf(
                '<a class="btn btn-sm btn-outline-dark" href="/specie-%s">%s &gt;</a>',
                $data['next']['slug'],
                $data['next']['name']
            )
            : '<span></span>';

        $detailCard = $this->renderer->render(
            Template::SPECIE_DETAIL_CARD,
            [
                $data['title'],
                $data['description'],
                $prevHtml,
                $nextHtml,
                $data['creatureType'],
                $data['sizeCategory'],
                $data['speed'],
                $data['powers'],
            ]
        );

        $contentSection = $this->renderer->render(
            Template::DETAIL_PAGE,
            ['', $detailCard]
        );

        return $this->renderer->render(
            Template::MAIN_PAGE,
            [$menuHtml, $contentSection]
        );
    }
}
