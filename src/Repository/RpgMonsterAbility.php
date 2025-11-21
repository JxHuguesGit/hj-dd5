<?php
namespace src\Repository;

use src\Entity\RpgMonsterAbility as EntityRpgMonsterAbility;

class RpgMonsterAbility extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgMonsterAbility::class;
    }
}
