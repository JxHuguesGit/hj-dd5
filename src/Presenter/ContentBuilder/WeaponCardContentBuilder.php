<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\WeaponRow;
use src\Utils\Html;

final class WeaponCardContentBuilder extends AbstractCardContentBuilder
{
    /** @param WeaponRow $weapon */
    protected function renderItem(object $weapon): string
    {
        $content = Html::getBalise(
            H::BALISE_H3,
            Html::getLink($weapon->name, $weapon->url)
        );

        $content .= $this->renderInfo(
            L::DAMAGES,
            $weapon->damage,
            [C::CSSCLASS => B::WEAPON_CARD_INFO]
        );

        $content .= $this->renderInfo(
            L::PROPERTIES,
            Html::getSpan(
                $weapon->properties,
                [C::CSSCLASS => C::WEAPON_PROPERTIES]
            ),
            [C::CSSCLASS => B::WEAPON_CARD_INFO]
        );

        $content .= $this->renderInfo(
            L::WEAPON_PROP,
            $weapon->masteryLink,
            [C::CSSCLASS => B::WEAPON_CARD_INFO]
        );

        $content .= $this->renderInfo(
            L::WEIGHT,
            $weapon->weight,
            [C::CSSCLASS => B::WEAPON_CARD_INFO]
        );

        $content .= $this->renderInfo(
            L::PRICE,
            $weapon->price,
            [C::CSSCLASS => B::WEAPON_CARD_INFO]
        );

        return Html::getBalise(
            H::BALISE_ARTICLE,
            $content,
            [C::CSSCLASS => B::DATA_CARD . L::SPACE . B::WEAPON_CARD]
        );
    }

    protected function renderInfo(string $label, string $value, array $attributes = []): string
    {
        return Html::getBalise(
            H::BALISE_DIV,
            sprintf(
                L::STRONG_INFO,
                $label,
                $value
            ),
            $attributes
        );
    }
}
