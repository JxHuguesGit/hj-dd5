<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Domain\Entity\Armor;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Presenter\ViewModel\ArmorPageView;
use src\Utils\Html;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

final class ArmorDetailContentBuilder implements ContentBuilderInterface
{
    public function build(object $view, array $params = []): string
    {
        /** @var ArmorPageView $view */

        $armor = $view->item;

        $content = Html::getBalise(
            H::BALISE_H1,
            $armor->name
        );

        $contentInfo =
            $this->renderInfo(
                L::TYPE,
                ArmorListPresenter::getTypesLabel()[$armor->armorTypeId][C::NAME]
            )
            . $this->renderInfo(
                L::CA,
                $armor->displayArmorClass()
            )
            . $this->renderInfo(
                L::FORCE,
                $armor->strengthPenalty ?: '-'
            )
            . $this->renderInfo(
                L::STEALTH,
                $armor->stealthDisadvantage
                    ? L::DISADVANTAGE
                    : '-'
            )
            . $this->renderInfo(
                L::WEIGHT,
                Utils::getStrWeight($armor->weight)
            )
            . $this->renderInfo(
                L::PRICE,
                Utils::getStrPrice($armor->goldPrice)
            );
        $content .= Html::getDiv(
            $contentInfo,
            [C::CSSCLASS => B::ARMOR_DETAIL_INFOS]
        );

        $content .= $this->renderNavigation(
            $view->previous,
            $view->next
        );

        return Html::getBalise(
            H::BALISE_ARTICLE,
            $content,
            [C::CSSCLASS => B::ARMOR_DETAIL]
        );
    }

    private function renderInfo(string $label, string $value): string
    {
        return Html::getBalise(
            H::BALISE_P,
            sprintf(L::STRONG_INFO, $label, $value),
            [C::CSSCLASS => B::ARMOR_DETAIL_INFO]
        );
    }

    private function renderNavigation(
        ?Armor $previous,
        ?Armor $next
    ): string {
        $previousHtml = $previous
            ? Html::getLink(
                '&lt; ' . $previous->name,
                UrlGenerator::item($previous->slug),
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
                UrlGenerator::item($next->slug),
                implode(' ', [
                    B::BTN,
                    B::BTN_SM,
                    B::BTN_OUTLINE_DARK,
                ])
            )
            : C::EMPTY_SPAN;

        return Html::getDiv(
            $previousHtml . $nextHtml,
            [C::CSSCLASS => B::ARMOR_DETAIL_NAVIGATION]
        );
    }
}
