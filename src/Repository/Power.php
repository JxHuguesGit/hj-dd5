<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Power as DomainPower;

class Power extends Repository
{
    public const TABLE = Table::POWER;

    public function getEntityClass(): string
    {
        return DomainPower::class;
    }
}
