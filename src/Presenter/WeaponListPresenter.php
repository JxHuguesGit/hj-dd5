<?php
namespace src\Presenter;

use src\Domain\RpgWeapon;
use src\Constant\Language;

class WeaponListPresenter
{
    public function present(iterable $weapons): array
    {
        $groups = [
            'simple_melee'  => [],
            'simple_ranged' => [],
            'martial_melee' => [],
            'martial_ranged'=> [],
        ];

        foreach ($weapons as $weapon) {
            /** @var RpgWeapon $weapon */
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
