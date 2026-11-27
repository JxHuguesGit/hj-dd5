<?php

namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterSubTypeCriteria;
use src\Domain\Entity\MonsterSubType;
use src\Repository\MonsterSubTypeRepositoryInterface;

final class MonsterSubTypeReader
{
    public function __construct(
        private MonsterSubTypeRepositoryInterface $repository,
    ) {}

    /**
     * @return ?MonsterSubType
     */
    public function monsterSubTypeById(int $id): ?MonsterSubType
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<MonsterSubType>
     */
    public function allMonsterSubTypes(?MonsterSubTypeCriteria $criteria = null): Collection
    {
        if (!$criteria) {
            $criteria = new MonsterSubTypeCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
