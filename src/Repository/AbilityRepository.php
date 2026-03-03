<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\AbilityCriteria;
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

    /**
     * @return Collection<Ability>
     */
    public function findAllWithCriteria(AbilityCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
