<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\RpgOriginAbility as DomainRpgOriginAbility;

class RpgOriginAbility extends Repository
{
    public const TABLE = Table::ORIGINABILITY;
    
    public function getEntityClass(): string
    {
        return DomainRpgOriginAbility::class;
    }
}
