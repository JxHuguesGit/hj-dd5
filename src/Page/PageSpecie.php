<?php
namespace src\Page;

use src\Constant\Constant;
use src\Constant\Template;
use src\Helper\NavigationHelper;
use src\Renderer\TemplateRenderer;

class PageSpecie
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}
    
    public function render(string $menuHtml, array $data): string
    {
        [$prevHtml, $nextHtml] = NavigationHelper::getPrevNext($data, Constant::SPECIE);

        $detailCard = $this->renderer->render(
            Template::SPECIE_DETAIL_CARD,
            [
                $data[Constant::CST_TITLE] ?? '',
                $data[Constant::CST_DESCRIPTION] ?? '',
                $prevHtml,
                $nextHtml,
                $data[Constant::CST_CREATURE_TYPE] ?? '-',
                $data[Constant::CST_SIZE_CATEGORY] ?? '-',
                $data[Constant::CST_SPEED] ?? '-',
                $data[Constant::CST_POWERS] ?? '-',
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
