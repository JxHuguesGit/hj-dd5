<?php
namespace src\Repository;

use src\Entity\RpgSpecies as EntityRpgSpecies;

class RpgSpecies extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgSpecies::class;
    }
}
