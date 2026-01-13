<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Feat as DomainFeat;

class FeatListPresenter
{
    public function present(Collection $feats): array
    {
        $grouped = [];
        foreach ($feats as $feat) {
            /** @var DomainFeat $feat */
            $grouped[$feat->featTypeId][] = $feat;
        }

        $typesSlug = [
            1 => Constant::ORIGIN,
            2 => Constant::GENERAL,
            3 => Constant::COMBAT,
            4 => Constant::EPIC,
        ];
        $typesLabel = [
            1 => Language::LG_ORIGIN_FEATS,
            2 => Language::LG_GENERAL_FEATS,
            3 => Language::LG_CBT_STYLE_FEATS,
            4 => Language::LG_CBT_STYLE_EPICS,
        ];

        $result = [];
        foreach ($grouped as $typeId => $featsByType) {
            $result[] = [
                Constant::CST_TYPELABEL => $typesLabel[$typeId] ?? '',
                Constant::CST_SLUG => $typesSlug[$typeId] ?? '',
                Constant::FEATS => $featsByType
            ];
        }

        return [Constant::CST_ITEMS=>$result];
    }
}
