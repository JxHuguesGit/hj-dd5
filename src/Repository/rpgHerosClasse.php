<?php
namespace src\Repository;

use src\Entity\RpgHerosClasse as EntityRpgHerosClasse;

class RpgHerosClasse extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgHerosClasse::class;
    }
}
