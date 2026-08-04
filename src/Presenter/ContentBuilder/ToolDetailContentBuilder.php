<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\ToolPageView;
use src\Utils\Html;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

final class ToolDetailContentBuilder extends AbstractDetailContentBuilder
{

    protected function renderDetailHeader(object $view) : string
    {
        return $this->renderHeader(
            $view->item->name,
            $view->item->parentName ?: L::TOOL_DIVERS,
            B::TOOL_TYPE
        );
    }

    protected function getDetailUrl(string $slug): string
    {
        return UrlGenerator::item($slug);
    }

    protected function renderDetailBody(object $view, array $params = []) : string
    {
        $tool = $view->item;

        $content = Html::getDiv(
            $this->renderInfo(
                L::WEIGHT,
                Utils::getStrWeight($tool->weight)
            )
            . $this->renderInfo(
                L::PRICE,
                Utils::getStrPrice($tool->goldPrice)
            )
            . $this->renderInfo(
                L::ABILITY,
                $tool->abilityName ?? ''
            ),
            [C::CSSCLASS => B::DATA_DETAIL_INFOS . L::SPACE . B::TOOL_DETAIL_INFOS]
        );

        $content .= $this->renderCraftableItems($view);

        $content .= $this->renderOrigins($view);

        $content .= Html::getBalise(
            H::BALISE_P,
            $tool->description ?? '',
            [C::CSSCLASS => B::DATA_DETAIL_DESCRIPTION . L::SPACE . B::TOOL_DETAIL_DESCRIPTION]
        );

        return $content;
    }

    private function renderCraftableItems(ToolPageView $view): string
    {
        if ($view->craftableItems->isEmpty()) {
            return '';
        }

        $items = '';

        foreach ($view->craftableItems as $item) {
            $items .= Html::getLink(
                $item->name,
                UrlGenerator::item($item->slug),
                B::BADGE
            );
        }

        return Html::getDiv(
            Html::getBalise(
                H::BALISE_STRONG,
                L::CRAFTSHIP
            )
            . Html::getDiv(
                $items,
                [C::CSSCLASS => B::TOOL_DETAIL_CRAFT_ITEM_VALUE]
            ),
            [C::CSSCLASS => B::TOOL_DETAIL_CRAFT_ITEMS]
        );
    }

    private function renderOrigins(ToolPageView $view): string
    {
        $content = '';

        if (!$view->origins->isEmpty()) {
            $badges = '';

            foreach ($view->origins as $origin) {
                $badges .= Html::getLink(
                    $origin->name,
                    UrlGenerator::origin($origin->slug),
                    B::BADGE
                );
            }

            $content .= Html::getDiv(
                $badges,
                [C::CSSCLASS => B::TOOL_DETAIL_ORIGINS_VALUE]
            );
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::TOOL_DETAIL_ORIGINS]
        );
    }

    private function renderInfo(string $label, string $value): string
    {
        $content = Html::getBalise(
            H::BALISE_STRONG,
            $label
        );

        $content .= Html::getDiv(
            $value,
            [C::CSSCLASS => B::TOOL_DETAIL_INFO_VALUE]
        );

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::DATA_DETAIL_INFO . B::TOOL_DETAIL_INFO]
        );
    }
}
