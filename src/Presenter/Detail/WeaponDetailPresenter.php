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

        $key = ($viewData->item->isMartial() ? C::MARTIAL : C::SIMPLE) . '_'
                . ($viewData->item->isMelee() ? C::MELEE : C::RANGED);
        $base[C::CATEGORY] = (WeaponListPresenter::getWeaponTypes())[$key][C::LABEL_SING];
        $base[C::DAMAGE] = Utils::getStrDamage($viewData->item);
        $base[C::PROPERTIES] = $this->formatter->properties($viewData->item);
        $base[C::MASTERYLINK] = $this->formatter->masteryLink($viewData->item);

        return $base;
    }
}
