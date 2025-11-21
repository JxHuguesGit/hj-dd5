<?php
namespace src\Repository;

use src\Entity\RpgMonsterCondition as EntityRpgMonsterCondition;

class RpgMonsterCondition extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgMonsterCondition::class;
    }
}
