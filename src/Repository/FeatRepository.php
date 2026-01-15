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

    public function find(int $id): DomainFeat
    {
        return parent::find($id) ?? new DomainFeat();
    }
}
