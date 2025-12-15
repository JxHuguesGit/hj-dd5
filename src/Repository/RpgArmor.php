<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\RpgArmor as DomainRpgArmor;

class RpgArmor extends Repository
{
    public const TABLE = Table::ARMOR;

    public function getEntityClass(): string
    {
        return DomainRpgArmor::class;
    }

}
