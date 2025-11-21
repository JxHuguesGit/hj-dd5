<?php
namespace src\Repository;

use src\Entity\RpgArmor as EntityRpgArmor;

class RpgArmor extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgArmor::class;
    }

}
