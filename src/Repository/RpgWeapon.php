<?php
namespace src\Repository;

use src\Entity\RpgWeapon as EntityRpgWeapon;

class RpgWeapon extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgWeapon::class;
    }
}
