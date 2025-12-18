<?php
namespace src\Page;

use src\Constant\Template;
use src\Renderer\TemplateRenderer;

class PageOrigine
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}

    public function render(string $menuHtml, array $data): string
    {
        $prevHtml = $data['prev']
            ? sprintf(
                '<a class="btn btn-sm btn-outline-dark" href="/origine-%s">&lt; %s</a>',
                $data['prev']['slug'],
                $data['prev']['name']
            )
            : '<span></span>';

        $nextHtml = $data['next']
            ? sprintf(
                '<a class="btn btn-sm btn-outline-dark" href="/origine-%s">%s &gt;</a>',
                $data['next']['slug'],
                $data['next']['name']
            )
            : '<span></span>';

        $urlFeat = '<a class="text-dark" href="/feat-'.$data['featSlug'].'">'.$data['originFeat'].'</a>';

        $detailCard = $this->renderer->render(
            Template::ORIGIN_DETAIL_CARD,
            [
                '',
                $data['title'],
                $data['description'],
                implode(', ', $data['abilities']),
                implode(', ', $data['skills']),
                $urlFeat,
                $data['originTool'],
                $data['originItem'],
                $prevHtml,
                $nextHtml,
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

