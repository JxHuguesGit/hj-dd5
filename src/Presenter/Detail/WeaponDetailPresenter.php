<?php
namespace src\Presenter\Detail;

use src\Constant\Constant;
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

        $key = ($viewData->weapon->isMartial() ? Constant::MARTIAL : Constant::SIMPLE) . '_'
                . ($viewData->weapon->isMelee() ? Constant::MELEE : Constant::RANGED);
        $base['category'] = (WeaponListPresenter::getWeaponTypes())[$key][Constant::LABEL_SING];
        $base['damage'] = Utils::getStrDamage($viewData->weapon);
        $base['properties'] = $this->formatter->properties($viewData->weapon);
        $base['masteryLink'] = $this->formatter->masteryLink($viewData->weapon);

        return $base;
    }
}
