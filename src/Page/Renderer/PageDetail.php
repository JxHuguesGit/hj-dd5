<?php
namespace src\Page\Renderer;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
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
        $prevHtml       = $this->renderNavLink($data[C::PREV] ?? null, C::PREV);
        $nextHtml       = $this->renderNavLink($data[C::NEXT] ?? null, C::NEXT);
        $detailCard     = $this->renderer->render($detailTemplate, array_merge($detailFields, [$prevHtml, $nextHtml]));
        $contentSection = $this->renderer->render(Template::DETAIL_PAGE, ['', $detailCard]);
        return $this->renderer->render(Template::MAIN_PAGE, [$menuHtml, $contentSection, '']);
    }

    private function renderNavLink(
        ?array $navData,
        string $direction
    ): string {
        if (! $navData) {
            return C::EMPTY_SPAN;
        }
        $label = $direction === C::PREV
            ? '&lt; ' . $navData[C::NAME]
            : $navData[C::NAME] . ' &gt;';
        return Html::getLink(
            $label,
            $this->getEntityUrl($navData[C::SLUG]),
            implode(' ', [B::BTN, B::BTN_SM, B::BTN_OUTLINE_DARK])
        );
    }

    abstract protected function getEntityUrl(string $slug): string;
}
