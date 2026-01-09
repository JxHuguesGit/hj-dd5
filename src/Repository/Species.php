<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Specie as DomainSpecies;

class Species extends Repository
{
    public const TABLE = Table::SPECIES;
    
    public function getEntityClass(): string
    {
        return DomainSpecies::class;
    }
}
