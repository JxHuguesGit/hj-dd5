<?php
namespace src\Repository;

use src\Entity\RpgAlignement as EntityRpgAlignement;

class RpgAlignement extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgAlignement::class;
    }
}
