<?php
namespace src\Repository;

use src\Entity\RpgPower as EntityRpgPower;

class RpgPower extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgPower::class;
    }
}
