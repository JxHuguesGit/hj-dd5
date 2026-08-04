<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\OriginGroup;
use src\Presenter\ViewModel\OriginRow;
use src\Utils\Html;

final class OriginCardContentBuilder extends AbstractCardContentBuilder
{
    /** @param OriginRow $row */
    protected function renderItem(object $row): string
    {
        $content = Html::getBalise(
            H::BALISE_H3,
            Html::getLink($row->name, $row->url)
        );

        $content .= $this->renderInfo(L::ABILITIES, $row->abilities);
        $content .= $this->renderInfo(L::ORIGIN_FEAT, $row->originFeat);
        $content .= $this->renderInfo(L::SKILLS, $row->skills);
        $content .= $this->renderInfo(L::TOOL, $row->tool);

        return $this->renderCard($content, B::ORIGIN_CARD);
    }

    /** @param OriginGroup $group */
    protected function renderGroupTitle(object $group): string
    {
        if ($group->label === '') {
            return '';
        }

        return parent::renderGroupTitle($group);
    }

    protected function renderInfo(string $label, string $value, array $attributes = []): string
    {
        if ($value === '') {
            return '';
        }

        return Html::getBalise(
            H::BALISE_P,
            sprintf(L::STRONG_INFO, $label, $value),
            $attributes
        );
    }
}
