<?php
namespace src\Repository;

use src\Entity\RpgSpeciesPower as EntityRpgSpeciesPower;

class RpgSpeciesPower extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgSpeciesPower::class;
    }
}
