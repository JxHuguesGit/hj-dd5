<?php
namespace src\Repository;

use src\Entity\RpgWeaponProficiency as EntityRpgWeaponProficiency;

class RpgWeaponProficiency extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgWeaponProficiency::class;
    }
}
