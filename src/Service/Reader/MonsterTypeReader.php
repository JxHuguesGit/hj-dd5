<?php

namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterTypeCriteria;
use src\Domain\Entity\MonsterType;
use src\Repository\MonsterTypeRepositoryInterface;

final class MonsterTypeReader
{
    public function __construct(
        private MonsterTypeRepositoryInterface $repository,
    ) {}

    /**
     * @return ?MonsterType
     */
    public function monsterTypeById(int $id): ?MonsterType
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<MonsterType>
     */
    public function allMonsterTypes(?MonsterTypeCriteria $criteria = null): Collection
    {
        if (!$criteria) {
            $criteria = new MonsterTypeCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
