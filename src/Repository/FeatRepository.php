<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Feat as DomainFeat;

class FeatRepository extends Repository implements FeatRepositoryInterface
{
    public const TABLE = Table::FEAT;
    
    public function getEntityClass(): string
    {
        return DomainFeat::class;
    }
}
