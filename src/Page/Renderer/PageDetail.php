<?php
namespace src\Page\Renderer;

use src\Constant\Bootstrap as B;
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
    ): string {
        // Navigation prev/next mutualisée
        $prevHtml       = $this->renderNavLink($data[Constant::PREV] ?? null, Constant::PREV);
        $nextHtml       = $this->renderNavLink($data[Constant::NEXT] ?? null, Constant::NEXT);
        $detailCard     = $this->renderer->render($detailTemplate, array_merge($detailFields, [$prevHtml, $nextHtml]));
        $contentSection = $this->renderer->render(Template::DETAIL_PAGE, ['', $detailCard]);
        return $this->renderer->render(Template::MAIN_PAGE, [$menuHtml, $contentSection, '']);
    }

    private function renderNavLink(
        ?array $navData,
        string $direction
    ): string {
        if (! $navData) {
            return Constant::EMPTY_SPAN;
        }
        $label = $direction === Constant::PREV
            ? '&lt; ' . $navData[Constant::NAME]
            : $navData[Constant::NAME] . ' &gt;';
        return Html::getLink(
            $label,
            $this->getEntityUrl($navData[Constant::SLUG]),
            implode(' ', [B::BTN, B::BTN_SM, B::BTN_OUTLINE_DARK])
        );
    }

    abstract protected function getEntityUrl(string $slug): string;
}
