<?php
namespace src\Page;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Template;
use src\Helper\NavigationHelper;
use src\Renderer\TemplateRenderer;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class PageOrigine
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}

    public function render(string $menuHtml, string $title, array $data): string
    {
        [$prevHtml, $nextHtml] = NavigationHelper::getPrevNext($data, Constant::ORIGIN);

        $parts = [];
        foreach ($data[Constant::CST_SKILLS] as $skill) {
            $parts[] = Html::getLink(
                $skill->name,
                UrlGenerator::skill($skill->getSlug()),
                Bootstrap::CSS_TEXT_DARK
            );
        }

        $urlFeat = $data[Constant::CST_FEAT]
            ? Html::getLink(
                $data[Constant::CST_FEAT][Constant::CST_NAME],
                UrlGenerator::feat($data[Constant::CST_FEAT][Constant::CST_SLUG]),
                Bootstrap::CSS_TEXT_DARK
            )
            : '-';

        $urlTool = $data[Constant::CST_TOOL]
            ? Html::getLink(
                $data[Constant::CST_TOOL][Constant::CST_NAME],
                UrlGenerator::item($data[Constant::CST_TOOL][Constant::CST_SLUG]),
                Bootstrap::CSS_TEXT_DARK
            )
            : '-';
        
        $detailCard = $this->renderer->render(
            Template::ORIGIN_DETAIL_CARD,
            [
                '',
                $title,
                $data[Constant::CST_DESCRIPTION],
                implode(', ', $data[Constant::CST_ABILITIES]),
                implode(', ', $parts),
                $urlFeat,
                $urlTool,
                implode(', ', $data[Constant::CST_EQUIPMENT]),
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

