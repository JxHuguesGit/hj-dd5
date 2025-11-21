<?php
namespace src\Repository;

use src\Entity\RpgWeaponWeaponProficiency as EntityRpgWeaponWeaponProficiency;

class RpgWeaponWeaponProficiency extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgWeaponWeaponProficiency::class;
    }
}
