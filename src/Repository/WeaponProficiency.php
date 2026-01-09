<?php
namespace src\Repository;

use src\Entity\WeaponProficiency as EntityRpgWeaponProficiency;

class WeaponProficiency extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgWeaponProficiency::class;
    }
}
