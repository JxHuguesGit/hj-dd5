<?php
namespace src\Presenter\Detail;

use src\Constant\Constant as C;
use src\Constant\Language as L;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Presenter\ViewModel\PageViewInterface;

class ArmorDetailPresenter extends AbstractItemDetailPresenter
{
    public function present(PageViewInterface $viewData): array
    {
        /** @var PageViewInterface $viewData */
        $base = parent::present($viewData);

        $base['armorTypeId']         = (ArmorListPresenter::getTypesLabel())[$viewData->item->armorTypeId][C::NAME];
        $base['armorClass']          = $viewData->item->displayArmorClass();
        $base['strengthPenalty']     = $viewData->item->strengthPenalty != 0 ? $viewData->item->strengthPenalty : '-';
        $base['stealthDisadvantage'] = $viewData->item->stealthDisadvantage ? L::DISADVANTAGE : '-';

        return $base;
    }
}
