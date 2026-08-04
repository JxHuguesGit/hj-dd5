<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\SpeciesRow;
use src\Utils\Html;

final class SpecieCardContentBuilder extends AbstractCardContentBuilder
{
    /** @param SpeciesRow $row */
    protected function renderItem(object $row): string
    {
        $content = Html::getBalise(
            H::BALISE_H3,
            Html::getLink($row->name, $row->url)
        );

        $content .= $this->renderInfo(L::TYPE, $row->creatureType);
        $content .= $this->renderInfo(L::HEIGHT, $row->sizeCategory);
        $content .= $this->renderInfo(L::SPEED, $row->speed);

        return $this->renderCard($content, B::SPECIE_CARD);
    }
}
