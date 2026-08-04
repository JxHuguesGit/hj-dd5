<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Presenter\ViewModel\FeatDetailView;
use src\Presenter\ViewModel\LinkView;
use src\Utils\Html;
use src\Utils\UrlGenerator;

final class FeatDetailContentBuilder extends AbstractDetailContentBuilder
{

    protected function renderDetailHeader(object $view) : string
    {
        return $this->renderHeader(
            $view->name,
            $this->renderType($view)
        );
    }

    protected function getDetailUrl(string $slug): string
    {
        return UrlGenerator::feat($slug);
    }

    protected function renderDetailBody(object $view, array $params = []) : string
    {
        return
            $this->renderDescription($view)
            . $this->renderOrigins($view);
    }

    private function renderType(FeatDetailView $view): string
    {
        $type = Html::getLink(
            htmlspecialchars($view->type->label),
            UrlGenerator::feats(L::DASH . $view->type->slug)
        );

        if ($view->type->prerequisite) {
            $type .= htmlspecialchars($view->type->prerequisite) . ')';
        }

        return $type;
    }

    private function renderDescription(FeatDetailView $view): string
    {
        if ($view->description === '') {
            return '';
        }

        return Html::getDiv(
            $view->description,
            [C::CSSCLASS => B::DATA_DETAIL_DESCRIPTION]
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
                [C::CSSCLASS => B::FEAT_ORIGIN]
            );
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::FEAT_ORIGINS]
        );
    }
}
