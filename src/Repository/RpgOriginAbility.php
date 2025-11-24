<?php
namespace src\Repository;

use src\Entity\RpgOriginAbility as EntityRpgOriginAbility;

class RpgOriginAbility extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgOriginAbility::class;
    }
}
