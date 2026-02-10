<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Entity\Ability;

class AbilityRepository extends Repository implements AbilityRepositoryInterface
{
    public const TABLE = Table::ABILITY;

    public function getEntityClass(): string
    {
        return Ability::class;
    }

    /**
     * @return ?Ability
     */
    public function find(int $id): ?Ability
    {
        return parent::find($id) ?? null;
    }
}
