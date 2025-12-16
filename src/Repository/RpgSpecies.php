<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\RpgSpecies as DomainRpgSpecies;

class RpgSpecies extends Repository
{
    public const TABLE = Table::SPECIES;
    
    public function getEntityClass(): string
    {
        return DomainRpgSpecies::class;
    }
}
