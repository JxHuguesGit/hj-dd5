<?php
namespace src\Repository;

use src\Entity\RpgFeatType as EntityRpgFeatType;

class RpgFeatType extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgFeatType::class;
    }
}
