<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Ability as DomainAbility;

class Ability extends Repository
{
    public const TABLE = Table::ABILITY;

    public function getEntityClass(): string
    {
        return DomainAbility::class;
    }
}
