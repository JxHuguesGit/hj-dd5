<?php
namespace src\Repository;

use src\Entity\RpgTypeAmmunition as EntityRpgTypeAmmunition;

class RpgTypeAmmunition extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgTypeAmmunition::class;
    }
}
