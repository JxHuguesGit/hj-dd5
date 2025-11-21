<?php
namespace src\Repository;

use src\Entity\RpgTypeDamage as EntityRpgTypeDamage;

class RpgTypeDamage extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgTypeDamage::class;
    }
}
