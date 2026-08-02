<?php
namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ViewModel\SpellDetail;
use src\Presenter\ViewModel\SpellPageView;
use src\Service\Formatter\SpellFormatter;
use src\Utils\Html;

final class SpellDetailContentBuilder implements ContentBuilderInterface
{
    public function build(object $view, array $params = []): string
    {
        /** @var SpellPageView $view */

        $spell = $view->spell;

        $content = Html::getBalise(
            H::BALISE_H1,
            $spell->name
        );

        $content .= Html::getBalise(
            H::BALISE_P,
            '<em>' .
            SpellFormatter::formatEcole($spell->ecole, $spell->niveau) .
            '<br>' .
            SpellFormatter::formatClasses($spell->classes) .
            '</em>'
        );

        $content .= $this->renderInfoList($spell);

        $content .= Html::getBalise(
            H::BALISE_DIV,
            $spell->description,
            [C::CSSCLASS => B::SPELL_DETAIL_DESCRIPTION]
        );

        $content .= $this->renderNavigation(
            $view->previous,
            $view->next
        );

        return Html::getBalise(
            H::BALISE_ARTICLE,
            $content,
            [C::CSSCLASS => B::SPELL_DETAIL]
        );
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

        return Html::getBalise(
            H::BALISE_DIV,
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

    private function renderNavigation(
        ?SpellDetail $previous,
        ?SpellDetail $next
    ): string {
        $previousHtml = $previous
            ? Html::getLink(
                '&lt; ' . $previous->name,
                $previous->url,
                implode(' ', [
                    B::BTN,
                    B::BTN_SM,
                    B::BTN_OUTLINE_DARK,
                ])
            )
            : C::EMPTY_SPAN;

        $nextHtml = $next
            ? Html::getLink(
                $next->name . ' &gt;',
                $next->url,
                implode(' ', [
                    B::BTN,
                    B::BTN_SM,
                    B::BTN_OUTLINE_DARK,
                ])
            )
            : C::EMPTY_SPAN;

        return Html::getDiv(
            $previousHtml . $nextHtml,
            [C::CSSCLASS => B::SPELL_DETAIL_NAVIGATION]
        );
    }
}
