<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MonsterAbilityCriteria;
use src\Domain\Entity\MonsterAbility;

class MonsterAbilityRepository extends Repository implements MonsterAbilityRepositoryInterface
{
    public const TABLE = Table::MSTABILITY;

    public function getEntityClass(): string
    {
        return MonsterAbility::class;
    }

    /**
     * @return Collection<MonsterAbility>
     */
    public function findAllWithCriteria(MonsterAbilityCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
