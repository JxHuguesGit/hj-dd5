<?php
namespace src\Repository;

use src\Entity\RpgMasteryProficiency as EntityRpgMasteryProficiency;

class RpgMasteryProficiency extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgMasteryProficiency::class;
    }
}
