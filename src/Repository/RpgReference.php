<?php
namespace src\Repository;

use src\Entity\RpgReference as EntityRpgReference;

class RpgReference extends Repository
{
    public function getEntityClass(): string
    {
        return EntityRpgReference::class;
    }
}
