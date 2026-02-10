<?php
namespace src\Presenter\Detail;

use src\Constant\Constant;
use src\Constant\Language;
use src\Presenter\ListPresenter\ArmorListPresenter;
use src\Presenter\ViewModel\PageViewInterface;

class ArmorDetailPresenter extends AbstractItemDetailPresenter
{
    public function present(PageViewInterface $viewData): array
    {
        /** @var PageViewInterface $viewData */
        $base = parent::present($viewData);

        $base['armorTypeId']         = (ArmorListPresenter::getTypesLabel())[$viewData->armor->armorTypeId][Constant::CST_NAME];
        $base['armorClass']          = $viewData->armor->displayArmorClass();
        $base['strengthPenalty']     = $viewData->armor->strengthPenalty != 0 ? $viewData->armor->strengthPenalty : '-';
        $base['stealthDisadvantage'] = $viewData->armor->stealthDisadvantage ? Language::LG_DISADVANTAGE : '-';

        return $base;
    }
}
