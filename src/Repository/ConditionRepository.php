<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\ConditionCriteria;
use src\Domain\Entity\Condition;

class ConditionRepository extends Repository implements ConditionRepositoryInterface
{
    public const TABLE = Table::CONDITION;

    public function getEntityClass(): string
    {
        return Condition::class;
    }

    /**
     * @return ?Condition
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Condition
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Condition>
     */
    public function findAllWithCriteria(ConditionCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
