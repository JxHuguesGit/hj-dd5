<?php
namespace src\Repository;

use src\Entity\RpgAbility as EntityRpgAbility;

class RpgAbility extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgAbility::class;
    }
}
