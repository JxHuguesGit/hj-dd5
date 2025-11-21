<?php
namespace src\Repository;

use src\Entity\RpgOrigin as EntityRpgOrigin;

class RpgOrigin extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgOrigin::class;
    }
}
