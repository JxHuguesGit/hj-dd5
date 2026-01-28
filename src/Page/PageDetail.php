<?php
namespace src\Page;

use src\Constant\Bootstrap;
use src\Constant\Constant;
use src\Constant\Template;
use src\Renderer\TemplateRenderer;
use src\Utils\Html;

abstract class PageDetail
{
    public function __construct(
        protected TemplateRenderer $renderer
    ) {}
    
     protected function renderDetail(
        string $menuHtml,
        array $data,
        string $detailTemplate,
        array $detailFields
    ): string
    {
        // Navigation prev/next mutualisée
        $prevHtml = $this->renderNavLink($data[Constant::CST_PREV] ?? null, Constant::CST_PREV);
        $nextHtml = $this->renderNavLink($data[Constant::CST_NEXT] ?? null, Constant::CST_NEXT);
        $detailCard = $this->renderer->render($detailTemplate, array_merge($detailFields, [$prevHtml, $nextHtml]));
        $contentSection = $this->renderer->render(Template::DETAIL_PAGE, ['', $detailCard]);
        return $this->renderer->render(Template::MAIN_PAGE, [$menuHtml, $contentSection, '']);
    }

    private function renderNavLink(
        ?array $navData,
        string $direction
    ): string
    {
        if (!$navData) {
            return Constant::CST_EMPTY_SPAN;
        }
        $label = $direction === Constant::CST_PREV
            ? '&lt; '.$navData[Constant::CST_NAME]
            : $navData[Constant::CST_NAME].' &gt;';
        return Html::getLink(
            $label,
            $this->getEntityUrl($navData[Constant::CST_SLUG]),
            implode(' ', [Bootstrap::CSS_BTN, Bootstrap::CSS_BTN_SM, Bootstrap::CSS_BTN_OUTLINE_DARK])
        );
    }
    
    abstract protected function getEntityUrl(string $slug): string;
}
