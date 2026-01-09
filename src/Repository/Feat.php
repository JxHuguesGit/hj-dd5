<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Feat as DomainFeat;

class Feat extends Repository
{
    public const TABLE = Table::FEAT;
    
    public function getEntityClass(): string
    {
        return DomainFeat::class;
    }
}
