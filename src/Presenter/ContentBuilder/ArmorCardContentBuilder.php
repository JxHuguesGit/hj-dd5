<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\ArmorRow;
use src\Utils\Html;

final class ArmorCardContentBuilder extends AbstractCardContentBuilder
{
    /** @param ArmorRow $armor */
    protected function renderItem(object $armor): string
    {
        $content = Html::getBalise(
            H::BALISE_H3,
            Html::getLink($armor->name, $armor->url)
        );

        $content .= $this->renderInfo(L::CA, $armor->armorClass);

        $content .= $this->renderInfo(
            L::FORCE,
            $armor->strengthPenalty ?: L::DASH
        );

        $content .= $this->renderInfo(
            L::STEALTH,
            $armor->stealth
        );

        $content .= $this->renderInfo(
            L::WEIGHT,
            $armor->weight
        );

        $content .= $this->renderInfo(
            L::PRICE,
            $armor->price
        );

        return $this->renderCard($content, B::ARMOR_CARD);
    }
}
