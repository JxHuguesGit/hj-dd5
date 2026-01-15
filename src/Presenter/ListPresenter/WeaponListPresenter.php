<?php
namespace src\Presenter\ListPresenter;

use src\Constant\Constant;
use src\Constant\Language;
use src\Domain\Weapon as DomainWeapon;
use src\Presenter\ViewModel\WeaponGroup;

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

        $types = self::getWeaponTypes();

        $result = [];
        foreach ($grouped as $typeId => $weaponsByType) {
            $result[] = new WeaponGroup(
                $types[$typeId][Constant::CST_LABEL] ?? '',
                $types[$typeId][Constant::CST_SLUG] ?? '',
                $weaponsByType
            );
        }

        return [Constant::CST_ITEMS=>$result];
    }

    public function getWeaponTypes(): array
    {
        return [
            Constant::CST_SIMPLE.'_'.Constant::CST_MELEE => [
                Constant::CST_SLUG  => Constant::CST_SIMPLE.'_'.Constant::CST_MELEE,
                Constant::CST_LABEL => Language::LG_WEAPONS
                    . Language::LG_WEAPON_SIMPLE
                    . Language::LG_WEAPON_MELEE,
            ],
            Constant::CST_SIMPLE.'_'.Constant::CST_RANGED => [
                Constant::CST_SLUG  => Constant::CST_SIMPLE.'_'.Constant::CST_RANGED,
                Constant::CST_LABEL => Language::LG_WEAPONS
                    . Language::LG_WEAPON_SIMPLE
                    . Language::LG_WEAPON_RANGED,
            ],
            Constant::CST_MARTIAL.'_'.Constant::CST_MELEE => [
                Constant::CST_SLUG  => Constant::CST_MARTIAL.'_'.Constant::CST_MELEE,
                Constant::CST_LABEL => Language::LG_WEAPONS
                    . Language::LG_WEAPON_MARTIAL
                    . Language::LG_WEAPON_MELEE,
            ],
            Constant::CST_MARTIAL.'_'.Constant::CST_RANGED => [
                Constant::CST_SLUG  => Constant::CST_MARTIAL.'_'.Constant::CST_RANGED,
                Constant::CST_LABEL => Language::LG_WEAPONS
                    . Language::LG_WEAPON_MARTIAL
                    . Language::LG_WEAPON_RANGED,
            ],
        ];
    }
}
