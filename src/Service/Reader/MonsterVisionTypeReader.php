<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterVisionTypeCriteria;
use src\Domain\Entity\MonsterVisionType;
use src\Repository\MonsterVisionTypeRepositoryInterface;

final class MonsterVisionTypeReader
{
    public function __construct(
        private MonsterVisionTypeRepositoryInterface $repository,
    ) {}

    /**
     * @return ?MonsterVisionType
     */
    public function monsterVisionTypeById(int $id): ?MonsterVisionType
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<MonsterVisionType>
     */
    public function monsterVisionTypesByMonsterId(int $monsterId): Collection
    {
        $criteria            = new MonsterVisionTypeCriteria();
        $criteria->monsterId = $monsterId;
        return $this->repository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<MonsterVisionType>
     */
    public function allMonsterVisionTypes(?MonsterVisionTypeCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria = new MonsterVisionTypeCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
