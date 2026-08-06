<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\GearRow;
use src\Utils\Html;

final class GearCardContentBuilder implements ContentBuilderInterface
{
    public function build(object $view): string
    {
        $cards = '';

        foreach ($view as $gear) {
            /** @var GearRow $gear */
            $cards .= $this->renderCard($gear);
        }

        return Html::getDiv(
            $cards,
            [C::CSSCLASS => B::DATA_GRID . L::SPACE . B::GEAR_GRID]
        );
    }

    private function renderCard(GearRow $gear): string
    {
        $content = Html::getBalise(
            H::BALISE_H3,
            Html::getLink(
                $gear->name,
                $gear->url
            )
        );

        $content .= $this->renderInfo(
            L::WEIGHT,
            $gear->weight
        );

        $content .= $this->renderInfo(
            L::PRICE,
            $gear->price
        );

        return Html::getBalise(
            H::BALISE_ARTICLE,
            $content,
            [C::CSSCLASS => B::DATA_CARD . L::SPACE . B::GEAR_CARD]
        );
    }

    private function renderInfo(string $label, string $value): string
    {
        return Html::getBalise(
            H::BALISE_P,
            sprintf(
                L::STRONG_INFO,
                $label,
                $value
            )
        );
    }
}
