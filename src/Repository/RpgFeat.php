<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\RpgFeat as DomainRpgFeat;

class RpgFeat extends Repository
{
    public const TABLE = Table::FEAT;
    
    public function getEntityClass(): string
    {
        return DomainRpgFeat::class;
    }
}
