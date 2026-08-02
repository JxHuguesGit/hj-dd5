<?php
namespace src\Presenter\ContentBuilder;

use src\Constant\Bootstrap as B;
use src\Constant\Constant as C;
use src\Constant\Html as H;
use src\Constant\Language as L;
use src\Domain\Entity\Weapon;
use src\Presenter\ListPresenter\WeaponListPresenter;
use src\Presenter\ViewModel\WeaponPageView;
use src\Service\Formatter\WeaponFormatter;
use src\Utils\Html;
use src\Utils\UrlGenerator;
use src\Utils\Utils;

final class WeaponDetailContentBuilder implements ContentBuilderInterface
{
    public function __construct(
        private WeaponFormatter $formatter
    ) {}

    public function build(object $view, array $params = []): string
    {
        /** @var WeaponPageView $view */

        $weapon = $view->item;

        $content = Html::getBalise(
            'header',
            Html::getBalise(
                H::BALISE_H1,
                $weapon->name
            ),
            [C::CSSCLASS => 'weapon-detail-header']
        );

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

        $content .= Html::getDiv(
            $contentInfo,
            [C::CSSCLASS => B::WEAPON_DETAIL_INFOS]
        );

        $content .= $this->renderNavigation(
            $view->previous,
            $view->next
        );

        return Html::getBalise(
            H::BALISE_ARTICLE,
            $content,
            [C::CSSCLASS => B::WEAPON_DETAIL]
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

    private function renderNavigation(
        ?Weapon $previous,
        ?Weapon $next
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
            [C::CSSCLASS => B::WEAPON_DETAIL_NAVIGATION]
        );
    }
}
