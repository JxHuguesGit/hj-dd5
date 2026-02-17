<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterSpeedTypeCriteria;
use src\Domain\Entity\MonsterSpeedType;
use src\Repository\MonsterSpeedTypeRepositoryInterface;

final class MonsterSpeedTypeReader
{
    public function __construct(
        private MonsterSpeedTypeRepositoryInterface $repository,
    ) {}

    /**
     * @return ?MonsterSpeedType
     */
    public function monsterSpeedTypeById(int $id): ?MonsterSpeedType
    {
        return $this->repository->find($id);
    }
    
    /**
     * @return Collection<MonsterSpeedType>
     */
    public function allMonsterSpeedTypes(?MonsterSpeedTypeCriteria $criteria = null): Collection
    {
        if (!$criteria) {
            $criteria = new MonsterSpeedTypeCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
