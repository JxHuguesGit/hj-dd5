<?php
namespace src\Presenter\Detail;

use src\Constant\Constant as C;
use src\Presenter\ListPresenter\WeaponListPresenter;
use src\Presenter\ViewModel\PageViewInterface;
use src\Service\Formatter\WeaponFormatter;
use src\Utils\Utils;

class WeaponDetailPresenter extends AbstractItemDetailPresenter
{
    public function __construct(
        private WeaponFormatter $formatter
    ) {}

    public function present(PageViewInterface $viewData): array
    {
        /** @var PageViewInterface $viewData */
        $base = parent::present($viewData);

        $key = ($viewData->weapon->isMartial() ? C::MARTIAL : C::SIMPLE) . '_'
                . ($viewData->weapon->isMelee() ? C::MELEE : C::RANGED);
        $base['category'] = (WeaponListPresenter::getWeaponTypes())[$key][C::LABEL_SING];
        $base['damage'] = Utils::getStrDamage($viewData->weapon);
        $base['properties'] = $this->formatter->properties($viewData->weapon);
        $base['masteryLink'] = $this->formatter->masteryLink($viewData->weapon);

        return $base;
    }
}
