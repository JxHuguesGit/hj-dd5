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
                ($weapon->isMartial() ? 'martial' : 'simple') . '_'
              . ($weapon->isMelee()   ? 'melee'   : 'ranged');

            $grouped[$key][] = $weapon;
        }

        $typesLabel = [
            1 => Language::LG_WEAPONS
                         . Language::LG_WEAPON_SIMPLE
                         . Language::LG_WEAPON_MELEE,
            2 => Language::LG_WEAPONS
                         . Language::LG_WEAPON_SIMPLE
                         . Language::LG_WEAPON_RANGED,
            3 => Language::LG_WEAPONS
                         . Language::LG_WEAPON_MARTIAL
                         . Language::LG_WEAPON_MELEE,
            4 => Language::LG_WEAPONS
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



        $groups = [
            'simple_melee'  => [],
            'simple_ranged' => [],
            'martial_melee' => [],
            'martial_ranged'=> [],
        ];

        foreach ($weapons as $weapon) {
            /** @var DomainWeapon $weapon */
            $key =
                ($weapon->isMartial() ? 'martial' : 'simple') . '_'
              . ($weapon->isMelee()   ? 'melee'   : 'ranged');

            $groups[$key][] = $weapon;
        }

        return ['items'=>[
            [
                'label' => Language::LG_WEAPONS
                         . Language::LG_WEAPON_SIMPLE
                         . Language::LG_WEAPON_MELEE,
                'weapons' => $groups['simple_melee'],
            ],
            [
                'label' => Language::LG_WEAPONS
                         . Language::LG_WEAPON_SIMPLE
                         . Language::LG_WEAPON_RANGED,
                'weapons' => $groups['simple_ranged'],
            ],
            [
                'label' => Language::LG_WEAPONS
                         . Language::LG_WEAPON_MARTIAL
                         . Language::LG_WEAPON_MELEE,
                'weapons' => $groups['martial_melee'],
            ],
            [
                'label' => Language::LG_WEAPONS
                         . Language::LG_WEAPON_MARTIAL
                         . Language::LG_WEAPON_RANGED,
                'weapons' => $groups['martial_ranged'],
            ],
        ]];
    }
}
