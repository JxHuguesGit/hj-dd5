<?php
namespace src\Presenter\ListPresenter;

use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Weapon as DomainWeapon;

class WeaponListPresenter
{
    public function present(iterable $weapons): array
    {
        $grouped = [];
        foreach ($weapons as $weapon) {
            /** @var DomainWeapon $weapon */
            $key =
                ($weapon->isMartial() ? Constant::CST_MARTIAL : Constant::CST_SIMPLE) . '_'
              . ($weapon->isMelee()   ? Constant::CST_MELEE   : Constant::CST_RANGED);

            $grouped[$key][] = $weapon;
        }

        $typesLabel = [
            Constant::CST_SIMPLE.'_'.Constant::CST_MELEE => Language::LG_WEAPONS
                         . Language::LG_WEAPON_SIMPLE
                         . Language::LG_WEAPON_MELEE,
            Constant::CST_SIMPLE.'_'.Constant::CST_RANGED => Language::LG_WEAPONS
                         . Language::LG_WEAPON_SIMPLE
                         . Language::LG_WEAPON_RANGED,
            Constant::CST_MARTIAL.'_'.Constant::CST_MELEE => Language::LG_WEAPONS
                         . Language::LG_WEAPON_MARTIAL
                         . Language::LG_WEAPON_MELEE,
            Constant::CST_MARTIAL.'_'.Constant::CST_RANGED => Language::LG_WEAPONS
                         . Language::LG_WEAPON_MARTIAL
                         . Language::LG_WEAPON_RANGED,
        ];

        $result = [];
        foreach ($grouped as $typeId => $weaponsByType) {
            $result[] = [
                Constant::CST_TYPELABEL => $typesLabel[$typeId] ?? '',
                Constant::WEAPONS => $weaponsByType
            ];
        }

        return [Constant::CST_ITEMS=>$result];
    }
}
