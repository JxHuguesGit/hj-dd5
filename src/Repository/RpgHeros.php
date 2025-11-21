<?php
namespace src\Repository;

use src\Entity\RpgHeros as EntityRpgHeros;

class RpgHeros extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgHeros::class;
    }
}
