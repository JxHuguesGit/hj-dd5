<?php
namespace src\Presenter\ListPresenter;

use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Armor as DomainArmor;

class ArmorListPresenter
{
    /**
     * Transforme une liste d'armures en tableau prêt pour le Renderer.
     * Groupé par type.
     */
    public function present(iterable $armors): array
    {
        $grouped = [];
        foreach ($armors as $armor) {
            /** @var DomainArmor $armor */
            $grouped[$armor->armorTypeId][] = $armor;
        }

        $typesLabel = [
            1 => Language::LG_ARM_LGT_DONDOFF,
            2 => Language::LG_ARM_MDM_DONDOFF,
            3 => Language::LG_ARM_HVY_DONDOFF,
            4 => Language::LG_ARM_SHD_DONDOFF,
        ];

        $result = [];
        foreach ($grouped as $typeId => $armorsByType) {
            $result[] = [
                Constant::CST_TYPELABEL => $typesLabel[$typeId] ?? '',
                Constant::ARMORS => $armorsByType
            ];
        }

        return [Constant::CST_ITEMS=>$result];
    }
}
