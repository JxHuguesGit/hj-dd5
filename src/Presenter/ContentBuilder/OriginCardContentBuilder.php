<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\OriginRow;
use src\Utils\Html;

final class OriginCardContentBuilder extends AbstractCardContentBuilder
{
    protected function renderItem(mixed $row): string
    {
        /** @var OriginRow $row */

        $content = Html::getBalise(
            H::BALISE_H3,
            Html::getLink($row->name, $row->url)
        );

        $content .= $this->renderInfo(L::ABILITIES, $row->abilities);
        $content .= $this->renderInfo(L::ORIGIN_FEAT, $row->originFeat);
        $content .= $this->renderInfo(L::SKILLS, $row->skills);
        $content .= $this->renderInfo(L::TOOL, $row->tool);

        return Html::getBalise(
            H::BALISE_ARTICLE,
            $content,
            [C::CSSCLASS => B::ORIGIN_CARD]
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
            [C::CSSCLASS => B::ORIGIN_GROUP_TITLE]
        );
    }

    protected function getGroupsClass(): string
    {
        return B::ORIGIN_GROUPS;
    }

    protected function getGroupClass(): string
    {
        return B::ORIGIN_GROUP;
    }

    protected function getGridClass(): string
    {
        return B::ORIGIN_GRID;
    }

    private function renderInfo(string $label, string $value): string
    {
        if ($value === '') {
            return '';
        }

        return Html::getBalise(
            H::BALISE_P,
            sprintf(L::STRONG_INFO, $label, $value)
        );
    }
}
