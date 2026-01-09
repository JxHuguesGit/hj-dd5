<?php
namespace src\Repository;

use src\Entity\WeaponWeaponProficiency as EntityRpgWeaponWeaponProficiency;

class WeaponWeaponProficiency extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgWeaponWeaponProficiency::class;
    }
}
