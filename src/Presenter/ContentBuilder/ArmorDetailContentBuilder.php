<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Presenter\ViewModel\ArmorPageView;
use src\Utils\Html;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

final class ArmorDetailContentBuilder extends AbstractDetailContentBuilder
{

    /** @param ArmorPageView $view */
    protected function renderDetailHeader(object $view) : string
    {
        return $this->renderHeader($view->item->name);
    }

    protected function getDetailUrl(string $slug): string
    {
        return UrlGenerator::item($slug);
    }

    /** @param ArmorPageView $view */
    protected function renderDetailBody(object $view) : string
    {
        $armor = $view->item;

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
                $armor->strengthPenalty ?: L::DASH
            )
            . $this->renderInfo(
                L::STEALTH,
                $armor->stealthDisadvantage
                    ? L::DISADVANTAGE
                    : L::DASH
            )
            . $this->renderInfo(
                L::WEIGHT,
                Utils::getStrWeight($armor->weight)
            )
            . $this->renderInfo(
                L::PRICE,
                Utils::getStrPrice($armor->goldPrice)
            );

        return Html::getDiv(
            $contentInfo,
            [C::CSSCLASS => B::ARMOR_DETAIL_INFOS]
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
}
