<?php
namespace src\Page;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Template;
use src\Renderer\TemplateRenderer;
use src\Utils\Html;
use src\Utils\UrlGenerator;

class PageSpecie
{
    public function __construct(
        private TemplateRenderer $renderer
    ) {}
    
    public function render(string $menuHtml, array $data): string
    {
        $prevHtml = $data[Constant::CST_PREV]
            ? Html::getLink(
                '&lt; '.$data[Constant::CST_PREV][Constant::CST_NAME],
                UrlGenerator::specie($data[Constant::CST_PREV][Constant::CST_SLUG]),
                implode(' ', [Bootstrap::CSS_BTN, Bootstrap::CSS_BTN_SM, Bootstrap::CSS_BTN_OUTLINE_DARK])
            )
            : Constant::CST_EMPTY_SPAN;

        $nextHtml = $data[Constant::CST_NEXT]
            ? Html::getLink(
                $data[Constant::CST_NEXT][Constant::CST_NAME].' &gt;',
                UrlGenerator::specie($data[Constant::CST_NEXT][Constant::CST_SLUG]),
                implode(' ', [Bootstrap::CSS_BTN, Bootstrap::CSS_BTN_SM, Bootstrap::CSS_BTN_OUTLINE_DARK])
            )
            : Constant::CST_EMPTY_SPAN;

        $detailCard = $this->renderer->render(
            Template::SPECIE_DETAIL_CARD,
            [
                $data[Constant::CST_TITLE],
                $data[Constant::CST_DESCRIPTION],
                $prevHtml,
                $nextHtml,
                $data[Constant::CST_CREATURE_TYPE],
                $data[Constant::CST_SIZE_CATEGORY],
                $data[Constant::CST_SPEED],
                $data[Constant::CST_POWERS],
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
