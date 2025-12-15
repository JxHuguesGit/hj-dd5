<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\RpgOrigin as DomainRpgOrigin;

class RpgOrigin extends Repository
{
    public const TABLE = Table::ORIGIN;
    
    public function getEntityClass(): string
    {
        return DomainRpgOrigin::class;
    }

}
