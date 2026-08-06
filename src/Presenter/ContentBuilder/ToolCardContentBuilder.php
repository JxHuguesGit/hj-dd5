<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\ToolRow;
use src\Utils\Html;

final class ToolCardContentBuilder extends AbstractCardContentBuilder
{
    /** @param ToolRow $tool */
    protected function renderItem(object $tool): string
    {
        $content = Html::getBalise(
            H::BALISE_H3,
            Html::getLink(
                $tool->name,
                $tool->url
            )
        );

        $contentInfos = Html::getBalise(
            H::BALISE_P,
            Html::getBalise(H::BALISE_STRONG, L::HISTORIQUES),
            [C::CSSCLASS => B::TOOL_CARD_ORIGINS_LABEL],
        );

        $contentInfos .= $this->renderInfo(
            L::WEIGHT,
            $tool->weight,
            [C::CSSCLASS => B::TOOL_CARD_WEIGHT],
        );

        $contentInfos .= Html::getBalise(
            H::BALISE_P,
            $tool->originLabel,
            [C::CSSCLASS => B::TOOL_CARD_ORIGINS],
        );

        $contentInfos .= $this->renderInfo(
            L::PRICE,
            $tool->price,
            [C::CSSCLASS => B::TOOL_CARD_PRICE],
        );

        $content .= Html::getDiv(
            $contentInfos,
            [C::CSSCLASS => B::TOOL_CARD_INFOS]
        );

        return $this->renderCard($content, B::TOOL_CARD);
    }
}
