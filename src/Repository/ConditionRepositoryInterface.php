<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\ConditionCriteria;
use src\Domain\Entity\Condition;

interface ConditionRepositoryInterface
{
    /**
     * @return ?Condition
     */
    public function find(int $id): ?Condition;

    /**
     * @return Collection<Condition>
     */
    public function findAllWithCriteria(ConditionCriteria $criteria): Collection;
}
