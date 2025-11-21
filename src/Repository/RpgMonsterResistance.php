<?php
namespace src\Repository;

use src\Entity\RpgMonsterResistance as EntityRpgMonsterResistance;

class RpgMonsterResistance extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgMonsterResistance::class;
    }
}
