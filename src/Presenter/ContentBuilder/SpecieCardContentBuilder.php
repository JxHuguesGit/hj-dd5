<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\SpecieRow;
use src\Utils\Html;

final class SpecieCardContentBuilder extends AbstractCardContentBuilder
{
    public function build(object $groups): string
    {
        return $this->getSourceFilters($groups) . parent::build($groups);
    }

    /** @param SpecieRow $row */
    protected function renderItem(object $row): string
    {
        $content = Html::getBalise(
            H::BALISE_H3,
            Html::getLink($row->name, $row->url)
        );

        $content .= $this->renderInfo(L::TYPE, $row->creatureType);
        $content .= $this->renderInfo(L::HEIGHT, $row->sizeCategory);
        $content .= $this->renderInfo(L::SPEED, $row->speed);

        return $this->renderCard($content, B::SPECIE_CARD . ' source source-' . strtolower($row->sourceCode));
    }
}
