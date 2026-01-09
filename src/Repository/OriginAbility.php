<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\OriginAbility as DomainOriginAbility;

class OriginAbility extends Repository
{
    public const TABLE = Table::ORIGINABILITY;
    
    public function getEntityClass(): string
    {
        return DomainOriginAbility::class;
    }
}
