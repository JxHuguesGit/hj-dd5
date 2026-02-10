<?php
namespace src\Repository;

use src\Domain\Entity\Alignement;

class AlignementRepository extends Repository
{
    public function getEntityClass(): string
    {
        return Alignement::class;
    }
}
