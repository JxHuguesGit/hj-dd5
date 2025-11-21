<?php
namespace src\Repository;

use src\Entity\RpgSousTypeMonstre as EntityRpgSousTypeMonstre;

class RpgSousTypeMonstre extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgSousTypeMonstre::class;
    }
}
