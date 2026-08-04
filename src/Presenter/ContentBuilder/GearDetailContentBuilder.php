<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Utils\Html;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

final class GearDetailContentBuilder extends AbstractDetailContentBuilder
{

    protected function renderDetailHeader(object $view) : string
    {
        return $this->renderHeader($view->item->name);
    }

    protected function getDetailUrl(string $slug): string
    {
        return UrlGenerator::item($slug);
    }

    protected function renderDetailBody(object $view, array $params = []) : string
    {
        $gear = $view->item;

        $linkBuildName = $gear->buildName
            ? Html::getLink(
                $gear->buildName,
                UrlGenerator::item($gear->buildSlug)
            )
            : L::DASH;

        $content = Html::getDiv(
            $this->renderInfo(
                L::WEIGHT,
                Utils::getStrWeight($gear->weight)
            )
            . $this->renderInfo(
                L::PRICE,
                Utils::getStrPrice($gear->goldPrice)
            )
            . $this->renderInfo(
                L::PRODUCEDBY,
                $linkBuildName
            ),
            [C::CSSCLASS => B::DATA_DETAIL_INFOS . L::SPACE . B::GEAR_DETAIL_INFOS]
        );

        $content .= Html::getBalise(
            H::BALISE_P,
            $gear->description,
            [C::CSSCLASS => B::DATA_DETAIL_DESCRIPTION . L::SPACE . B::GEAR_DETAIL_DESCRIPTION]
        );

        return $content;
    }

    private function renderInfo(string $label, string $value): string
    {
        $content = Html::getBalise(
            H::BALISE_STRONG,
            $label
        );

        $content .= Html::getDiv(
            $value
        );

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::DATA_DETAIL_INFO . L::SPACE . B::GEAR_DETAIL_INFO]
        );
    }
}
