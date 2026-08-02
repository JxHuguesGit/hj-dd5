<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\SpeciesRow;
use src\Utils\Html;

final class SpecieCardContentBuilder extends AbstractCardContentBuilder
{
    protected function renderItem(mixed $row): string
    {
        /** @var SpeciesRow $row */

        $content = Html::getBalise(
            H::BALISE_H3,
            Html::getLink($row->name, $row->url)
        );

        $content .= $this->renderInfo(L::TYPE, $row->creatureType);
        $content .= $this->renderInfo(L::HEIGHT, $row->sizeCategory);
        $content .= $this->renderInfo(L::SPEED, $row->speed);

        return Html::getBalise(
            H::BALISE_ARTICLE,
            $content,
            [C::CSSCLASS => B::SPECIE_CARD]
        );
    }

    protected function renderGroupTitle(mixed $group): string
    {
        if ($group->label === '') {
            return '';
        }

        return Html::getBalise(
            H::BALISE_H2,
            htmlspecialchars($group->label),
            [C::CSSCLASS => B::SPECIE_GROUP_TITLE]
        );
    }

    protected function getGroupsClass(): string
    {
        return B::SPECIE_GROUPS;
    }

    protected function getGroupClass(): string
    {
        return B::SPECIE_GROUP;
    }

    protected function getGridClass(): string
    {
        return B::SPECIE_GRID;
    }

    private function renderInfo(string $label, string $value): string
    {
        if ($value === '') {
            return '';
        }

        return Html::getBalise(
            H::BALISE_P,
            sprintf(L::STRONG_INFO, $label, htmlspecialchars($value))
        );
    }
}
