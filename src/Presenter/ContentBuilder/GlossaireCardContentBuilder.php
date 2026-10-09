<?php
namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Html as H;
use src\Utils\Html;

final class GlossaireCardContentBuilder
    extends AbstractCardContentBuilder
{
    protected function renderItem(object $row): string
    {
        $htmlContent =
            Html::getBalise(
                H::BALISE_H3,
                $row->title
            );

        $htmlContent .=
            Html::getBalise(
                H::BALISE_DIV,
                $row->content
            );

        return $this->renderCard(
            $htmlContent,
            B::SKILL_CARD
        );
    }

    protected function getGroupId (object $group): string
    {
        return '';
    }
}
