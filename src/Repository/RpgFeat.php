<?php
namespace src\Repository;

use src\Entity\RpgFeat as EntityRpgFeat;

class RpgFeat extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgFeat::class;
    }
}
