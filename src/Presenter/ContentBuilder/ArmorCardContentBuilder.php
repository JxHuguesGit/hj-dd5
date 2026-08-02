<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\ArmorGroup;
use src\Presenter\ViewModel\ArmorRow;
use src\Utils\Html;

final class ArmorCardContentBuilder implements ContentBuilderInterface
{
    public function build(object $view, array $params = []): string
    {
        $content = '';

        foreach ($view as $group) {
            /** @var ArmorGroup $group */
            $content .= $this->renderGroup($group);
        }

        return Html::getDiv(
            $content,
            [C::CSSCLASS => B::ARMOR_LIST]
        );
    }

    private function renderGroup(ArmorGroup $group): string
    {
        $cards = '';

        foreach ($group->rows as $armor) {
            /** @var ArmorRow $armor */
            $cards .= $this->renderCard($armor);
        }

        return Html::getDiv(
            Html::getBalise(
                H::BALISE_H2,
                $group->label
            ) .
            Html::getDiv(
                $cards,
                [C::CSSCLASS => B::ARMOR_GRID]
            ),
            [C::CSSCLASS => B::ARMOR_GROUP]
        );
    }

    private function renderCard(ArmorRow $armor): string
    {
        $content = Html::getBalise(
            H::BALISE_H3,
            Html::getLink(
                $armor->name,
                $armor->url
            )
        );

        $content .= $this->renderInfo(L::CA, $armor->armorClass);

        $content .= $this->renderInfo(
            L::FORCE,
            $armor->strengthPenalty ?: '-'
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

        return Html::getBalise(
            H::BALISE_ARTICLE,
            $content,
            [C::CSSCLASS => B::ARMOR_CARD]
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
