<?php
namespace src\Page;

use src\Constant\Constant;
use src\Constant\Template;
use src\Helper\NavigationHelper;
use src\Renderer\TemplateRenderer;

class PageFeat
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}
    
    public function render(string $menuHtml, array $data): string
    {
        [$prevHtml, $nextHtml] = NavigationHelper::getPrevNext($data, Constant::CST_FEAT);
        
        $detailCard = $this->renderer->render(
            Template::FEAT_DETAIL_CARD,
            [
                '',
                $data[Constant::CST_TITLE] ?? '',
                $data[Constant::CST_DESCRIPTION] ?? '',
                $prevHtml,
                $nextHtml,
                $data[Constant::CST_FEATTYPE] ?? '-',
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
