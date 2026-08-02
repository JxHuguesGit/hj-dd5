<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Icon;
use src\Constant\Language as L;
use src\Presenter\ViewModel\SpellRow;
use src\Service\Formatter\SpellFormatter;
use src\Utils\Html;

final class SpellCardContentBuilder implements ContentBuilderInterface
{
    public function build(object $rows, array $params = []): string
    {
        $contentFilter = Html::getDiv(
            Html::getDiv(
                Html::getIcon(Icon::FILTER) . ' Filtrer les sorts',
                [
                    C::CSSCLASS => 'ajaxAction',
                    C::DATA     => [
                        C::TRIGGER => C::CLICK,
                        C::ACTION  => C::OPENMODAL,
                        C::TARGET  => 'spellFilter',
                    ],
                ]
            ),
            [C::CSSCLASS => 'spell-filter']
        );

        $contentSpellGrid = '';

        foreach ($rows as $row) {
            $contentSpellGrid .= $this->renderItem($row);
        }

        $contentSpellList = Html::getDiv(
            $contentSpellGrid,
            [C::CSSCLASS => B::SPELL_GRID]
        );

        $strIcon = Html::getIcon(Icon::CIRCLEPLUS);
        $contentSpellList .= Html::getDiv(
            $strIcon,
            [
                C::CSSCLASS => 'ajaxAction spell-load-more',
                C::DATA     => [
                    C::TRIGGER => C::CLICK,
                    C::ACTION  => C::LOADMORESPELLS,
                ],
            ]
        );

        return Html::getDiv(
            $contentFilter . $contentSpellList,
            [C::CSSCLASS => B::SPELL_LIST]
        );
    }

    private function renderItem(SpellRow $row): string
    {
        $content = Html::getBalise(
            H::BALISE_H3,
            Html::getLink($row->name, $row->url)
        );

        $content .= $this->renderInfo(
            L::LEVEL,
            $row->niveau . ' — ' . $row->ecole
        );

        $content .= $this->renderInfo(
            L::CLASSES,
            SpellFormatter::formatClasses($row->classes, false)
        );

        $content .= $this->renderInfo(
            L::INCTIME,
            SpellFormatter::formatIncantation($row->tpsInc, $row->rituel)
        );

        $content .= $this->renderInfo(
            L::RANGE,
            SpellFormatter::formatPortee($row->portee)
        );

        $content .= $this->renderInfo(
            L::DURATION,
            SpellFormatter::formatDuree(
                $row->duree,
                $row->concentration
            )
        );

        $content .= $this->renderInfo(
            L::COMPONENTS,
            SpellFormatter::formatComposantes(
                $row->composantes,
                $row->composanteMaterielle,
                false
            )
        );

        return Html::getBalise(
            H::BALISE_ARTICLE,
            $content,
            [C::CSSCLASS => B::SPELL_CARD]
        );
    }

    private function renderInfo(string $label, string $value): string
    {
        if ($value === '') {
            return '';
        }

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
