<?php

namespace src\Presenter\ContentBuilder;

use src\Presenter\ViewModel\FeatDetailView;
use src\Presenter\ViewModel\LinkView;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class FeatDetailContentBuilder implements ContentBuilderInterface
{
    public function build(mixed $data, array $params = []): string
    {
        /** @var FeatDetailView $view */
        $view = $data;

        return Html::getBalise(
            'section',
            $this->renderContent($view),
            ['class' => 'feat-detail']
        );
    }

    private function renderContent(FeatDetailView $view): string
    {
        return
            $this->renderHeader($view)
            . $this->renderDescription($view)
            . $this->renderOrigins($view)
            . $this->renderNavigation($view);
    }

    private function renderHeader(FeatDetailView $view): string
    {
        return sprintf(
            '<header class="feat-detail-header">
                <h1>%s</h1>%s
            </header>',
            htmlspecialchars($view->name),
            $this->renderType($view)
        );
    }

    private function renderDescription(FeatDetailView $view): string
    {
        if ($view->description === '') {
            return '';
        }

        return Html::getDiv(
            $view->description,
            ['class' => 'feat-description']
        );
    }

    private function renderType(FeatDetailView $view): string
    {
        $type = Html::getLink(
            htmlspecialchars($view->type->label),
            UrlGenerator::feats('-'.$view->type->slug)
        );

        if ($view->type->prerequisite) {
            $type .= htmlspecialchars($view->type->prerequisite) . ')';
        }

        return Html::getSpan(
            $type,
            ['class' => 'feat-type']
        );
    }

    private function renderOrigins(FeatDetailView $view): string
    {
        if (!$view->origins) {
            return '';
        }

        $content = '';

        foreach ($view->origins as $origin) {
            /** @var LinkView $origin */

            $content .= Html::getDiv(
                Html::getLink(
                    htmlspecialchars($origin->name),
                    UrlGenerator::origin($origin->slug)
                ),
                ['class' => 'feat-origin']
            );
        }

        return Html::getDiv(
            $content,
            ['class' => 'feat-origins']
        );
    }

    private function renderNavigation(FeatDetailView $view): string
    {
        $content = '';

        if ($view->previous) {
            $content .= Html::getLink(
                '&lt; ' . htmlspecialchars($view->previous->name),
                UrlGenerator::feat($view->previous->slug),
                'btn btn-sm btn-outline-dark'
            );
        }

        if ($view->next) {
            $content .= Html::getLink(
                htmlspecialchars($view->next->name) . ' &gt;',
                UrlGenerator::feat($view->next->slug),
                'btn btn-sm btn-outline-dark'
            );
        }

        if ($content === '') {
            return '';
        }

        $class = 'feat-navigation';

        if (!$view->previous) {
            $class .= ' only-next';
        }

        if (!$view->next) {
            $class .= ' only-prev';
        }

        return Html::getDiv(
            $content,
            ['class' => $class]
        );
    }
}
