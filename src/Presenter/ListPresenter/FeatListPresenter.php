<?php
namespace src\Presenter\ListPresenter;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Feat as DomainFeat;
use src\Presenter\ViewModel\FeatGroup;

class FeatListPresenter
{
    public function present(Collection $feats): array
    {
        $grouped = [];
        foreach ($feats as $feat) {
            /** @var DomainFeat $feat */
            $grouped[$feat->featTypeId][] = $feat;
        }

        $types = self::getFeatTypes();

        $result = [];
        foreach ($grouped as $typeId => $featsByType) {
            $result[] = new FeatGroup(
                $types[$typeId][Constant::CST_LABEL] ?? '',
                $types[$typeId][Constant::CST_SLUG] ?? '',
                $types[$typeId][Constant::CST_EXTRA_PREREQUIS] ?? '',
                $featsByType
            );
        }

        return [Constant::CST_ITEMS=>$result];
    }

    /**
     * Labels des types de dons.
     * @return array<int,array{slug:string,label:string}>
     */
    private static function getFeatTypes(): array {
        return [
            DomainFeat::TYPE_ORIGIN  => [
                Constant::CST_SLUG=>Constant::ORIGIN,
                Constant::CST_LABEL=>Language::LG_ORIGIN_FEATS,
                Constant::CST_EXTRA_PREREQUIS=>''
            ],
            DomainFeat::TYPE_GENERAL => [
                Constant::CST_SLUG=>Constant::GENERAL,
                Constant::CST_LABEL=>Language::LG_GENERAL_FEATS,
                Constant::CST_EXTRA_PREREQUIS=>Constant::CST_PREREQUIS_NIV4.')'
            ],
            DomainFeat::TYPE_COMBAT  => [
                Constant::CST_SLUG=>Constant::COMBAT,
                Constant::CST_LABEL=>Language::LG_CBT_STYLE_FEATS,
                Constant::CST_EXTRA_PREREQUIS=>Constant::CST_PREREQUIS_ASDC.')'
            ],
            DomainFeat::TYPE_EPIC    => [
                Constant::CST_SLUG=>Constant::EPIC,
                Constant::CST_LABEL=>Language::LG_CBT_STYLE_EPICS,
                Constant::CST_EXTRA_PREREQUIS=>Constant::CST_PREREQUIS_NIV19.')'
            ],
        ];
    }
}
