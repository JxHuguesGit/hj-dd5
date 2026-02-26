<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterConditionCriteria;
use src\Domain\Entity\MonsterCondition;
use src\Repository\MonsterConditionRepositoryInterface;

final class MonsterConditionReader
{
    public function __construct(
        private MonsterConditionRepositoryInterface $repository,
    ) {}

    /**
     * @return ?MonsterCondition
     */
    public function monsterConditionById(int $id): ?MonsterCondition
    {
        return $this->repository->find($id);
    }

    public function monsterConditionsByMonsterId(int $id): Collection
    {
        $criteria            = new MonsterConditionCriteria();
        $criteria->monsterId = $id;
        return $this->repository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<MonsterCondition>
     */
    public function allMonsterConditions(?MonsterConditionCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria = new MonsterConditionCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
