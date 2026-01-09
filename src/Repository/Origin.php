<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Origin as DomainOrigin;

class Origin extends Repository
{
    public const TABLE = Table::ORIGIN;
    
    public function getEntityClass(): string
    {
        return DomainOrigin::class;
    }

}
