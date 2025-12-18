<?php
namespace src\Presenter;

use src\Domain\RpgArmor as DomainRpgArmor;
use src\Constant\Language;

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
            /** @var DomainRpgArmor $armor */
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
                'typeLabel' => $typesLabel[$typeId] ?? 'Unknown',
                'armors' => $armorsByType
            ];
        }

        return ['items'=>$result];
    }
}
