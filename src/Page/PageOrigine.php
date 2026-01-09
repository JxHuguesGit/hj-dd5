<?php
namespace src\Page;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Template;
use src\Renderer\TemplateRenderer;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class PageOrigine
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}

    public function render(string $menuHtml, array $data): string
    {
        $prevHtml = $data[Constant::CST_PREV]
            ? Html::getLink(
                '&lt; '.$data[Constant::CST_PREV][Constant::CST_NAME],
                UrlGenerator::origin($data[Constant::CST_PREV][Constant::CST_SLUG]),
                implode(' ', [Bootstrap::CSS_BTN, Bootstrap::CSS_BTN_SM, Bootstrap::CSS_BTN_OUTLINE_DARK])
            )
            : Constant::CST_EMPTY_SPAN;

        $nextHtml = $data[Constant::CST_NEXT]
            ? Html::getLink(
                $data[Constant::CST_NEXT][Constant::CST_NAME].' &gt;',
                UrlGenerator::origin($data[Constant::CST_NEXT][Constant::CST_SLUG]),
                implode(' ', [Bootstrap::CSS_BTN, Bootstrap::CSS_BTN_SM, Bootstrap::CSS_BTN_OUTLINE_DARK])
            )
            : Constant::CST_EMPTY_SPAN;

        $urlFeat = Html::getLink(
            $data[Constant::CST_FEATNAME],
            UrlGenerator::feat($data[Constant::CST_FEATSLUG]),
            Bootstrap::CSS_TEXT_DARK
        );
        
        $detailCard = $this->renderer->render(
            Template::ORIGIN_DETAIL_CARD,
            [
                '',
                $data[Constant::CST_TITLE],
                $data[Constant::CST_DESCRIPTION],
                implode(', ', $data[Constant::CST_ABILITIES]),
                implode(', ', $data[Constant::CST_SKILLS]),
                $urlFeat,
                $data[Constant::CST_TOOLNAME],
                $data[Constant::CST_EQUIPMENT],
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

