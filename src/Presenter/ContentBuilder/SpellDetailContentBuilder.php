<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\SpellDetail;
use src\Service\Formatter\SpellFormatter;
use src\Utils\Html;

final class SpellDetailContentBuilder extends AbstractDetailContentBuilder
{
    
    protected function renderDetailHeader(object $view) : string
    {
        return $this->renderHeader(
            $view->spell->name,
            Html::getBalise(
                H::BALISE_EM,
                SpellFormatter::formatEcole($view->spell->ecole, $view->spell->niveau) .
                '<br>' .
                SpellFormatter::formatClasses($view->spell->classes)
            )
        );
    }

    protected function getDetailUrl(string $slug): string
    {
        return '';
    }

    protected function renderDetailNavigation(object $view): string
    {
        return $this->renderNavigation(
            $view->previous
                ? $view->previous->url
                : null,
            $view->previous?->name,
            $view->next
                ? $view->next->url
                : null,
            $view->next?->name
        );
    }

    protected function renderDetailBody(object $view, array $params = []) : string
    {
        $spell = $view->spell;

        $content = $this->renderInfoList($spell);

        $content .= Html::getDiv(
            $spell->description,
            [C::CSSCLASS => B::DATA_DETAIL_DESCRIPTION . L::SPACE . B::SPELL_DETAIL_DESCRIPTION]
        );
        return $content;
    }

    private function renderInfoList(SpellDetail $spell): string
    {
        $content = '';

        $content .= $this->renderInfo(
            L::INCTIME,
            SpellFormatter::formatIncantation(
                $spell->tpsInc,
                $spell->rituel
            )
        );

        $content .= $this->renderInfo(
            L::DURATION,
            SpellFormatter::formatDuree(
                $spell->duree,
                $spell->concentration
            )
        );

        $content .= $this->renderInfo(
            L::RANGE,
            SpellFormatter::formatPortee($spell->portee)
        );

        $content .= $this->renderInfo(
            L::COMPONENTS,
            SpellFormatter::formatComposantes(
                $spell->composantes,
                $spell->composanteMaterielle,
                true
            )
        );

        return Html::getDiv(
            Html::getBalise(H::BALISE_DL, $content),
            [C::CSSCLASS => B::SPELL_DETAIL_INFO]
        );
    }

    private function renderInfo(string $label, string $value): string
    {
        return Html::getBalise(
            H::BALISE_DT,
            $label
        ) .
        Html::getBalise(
            H::BALISE_DD,
            $value
        );
    }
}
