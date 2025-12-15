<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\RpgAbility as DomainRpgAbility;

class RpgAbility extends Repository
{
    public const TABLE = Table::ABILITY;

    public function getEntityClass(): string
    {
        return DomainRpgAbility::class;
    }
}
