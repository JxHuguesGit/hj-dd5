<?php
namespace src\Repository;

use src\Entity\RpgTypeVision as EntityRpgTypeVision;

class RpgTypeVision extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgTypeVision::class;
    }
}
