<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\ConditionCriteria;
use src\Domain\Entity\Condition;
use src\Repository\ConditionRepositoryInterface;

final class ConditionReader
{
    public function __construct(
        private ConditionRepositoryInterface $repository
    ) {}

    /**
     * @return ?Condition
     */
    public function conditionById(int $id): ?Condition
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<Condition>
     */
    public function allConditions(?ConditionCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria = new ConditionCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
