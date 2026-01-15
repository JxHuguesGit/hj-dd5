<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Ability as DomainAbility;

class AbilityRepository extends Repository implements AbilityRepositoryInterface
{
    public const TABLE = Table::ABILITY;

    public function getEntityClass(): string
    {
        return DomainAbility::class;
    }

    public function find(int $id): DomainAbility
    {
        return parent::find($id) ?? new DomainAbility();
    }
}
