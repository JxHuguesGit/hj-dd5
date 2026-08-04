<?php

namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Presenter\ListPresenter\WeaponListPresenter;
use src\Service\Formatter\WeaponFormatter;
use src\Utils\Html;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

final class WeaponDetailContentBuilder extends AbstractDetailContentBuilder
{
    public function __construct(
        private WeaponFormatter $formatter
    ) {}

    protected function renderDetailHeader(object $view) : string
    {
        return $this->renderHeader($view->item->name);
    }

    protected function getDetailUrl(string $slug): string
    {
        return UrlGenerator::item($slug);
    }

    protected function renderDetailBody(object $view, array $params = []) : string
    {
        $weapon = $view->item;

        $key = ($weapon->isMartial() ? C::MARTIAL : C::SIMPLE) . '_'
            . ($weapon->isMelee() ? C::MELEE : C::RANGED);

        $contentInfo =
            $this->renderInfo(
                L::TYPE,
                WeaponListPresenter::getWeaponTypes()[$key][C::LABEL_SING]
            )
            . $this->renderInfo(
                L::DAMAGES,
                Utils::getStrDamage($weapon)
            )
            . $this->renderInfo(
                L::PROPERTIES,
                $this->formatter->properties($weapon)
            )
            . $this->renderInfo(
                L::WEAPON_PROP,
                $this->formatter->masteryLink($weapon)
            )
            . $this->renderInfo(
                L::WEIGHT,
                Utils::getStrWeight($weapon->weight)
            )
            . $this->renderInfo(
                L::PRICE,
                Utils::getStrPrice($weapon->goldPrice)
            );

        return Html::getDiv(
            $contentInfo,
            [C::CSSCLASS => B::WEAPON_DETAIL_INFOS]
        );
    }

    private function renderInfo(string $label, string $value): string
    {
        $content = Html::getBalise(
            H::BALISE_STRONG,
            $label
        );

        $content .= Html::getDiv(
            $value,
            [C::CSSCLASS => B::WEAPON_DETAIL_INFO_VALUE]
        );

        return Html::getBalise(
            H::BALISE_DIV,
            $content,
            [C::CSSCLASS => B::WEAPON_DETAIL_INFO]
        );
    }
}
