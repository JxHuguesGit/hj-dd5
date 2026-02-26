<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterConditionCriteria;

interface MonsterConditionRepositoryInterface
{
    /**
     * @return Collection<MonsterCondition>
     */
    public function findAllWithCriteria(MonsterConditionCriteria $criteria): Collection;
}
