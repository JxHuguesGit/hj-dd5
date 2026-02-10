<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Entity\SpeciePower as DomainSpeciePower;

class SpeciePower extends Repository
{
    public const TABLE = Table::SPECIEPOWER;
    
    public function getEntityClass(): string
    {
        return DomainSpeciePower::class;
    }
}
