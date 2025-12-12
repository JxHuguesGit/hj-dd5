<?php
namespace src\Repository;

use src\Entity\RpgTypeMonstre as EntityRpgTypeMonstre;

class RpgTypeMonstre extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgTypeMonstre::class;
    }
}
