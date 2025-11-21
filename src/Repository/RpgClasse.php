<?php
namespace src\Repository;

use src\Entity\RpgClasse as EntityRpgClasse;

class RpgClasse extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgClasse::class;
    }

}
