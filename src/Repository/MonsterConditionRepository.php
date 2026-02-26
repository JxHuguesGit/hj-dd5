<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MonsterConditionCriteria;
use src\Domain\Entity\MonsterCondition;

class MonsterConditionRepository extends Repository implements MonsterConditionRepositoryInterface
{
    public const TABLE = Table::MSTCONDITION;

    public function getEntityClass(): string
    {
        return MonsterCondition::class;
    }

    /**
     * @return Collection<MonsterCondition>
     */
    public function findAllWithCriteria(MonsterConditionCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
