<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterResistanceCriteria;
use src\Domain\Entity\MonsterResistance;
use src\Repository\MonsterResistanceRepositoryInterface;

final class MonsterResistanceReader
{
    public function __construct(
        private MonsterResistanceRepositoryInterface $repository,
    ) {}

    /**
     * @return ?MonsterResistance
     */
    public function monsterResistanceById(int $id): ?MonsterResistance
    {
        return $this->repository->find($id);
    }

    public function monsterResistancesByMonsterId(int $id): Collection
    {
        $criteria            = new MonsterResistanceCriteria();
        $criteria->monsterId = $id;
        return $this->repository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<MonsterResistance>
     */
    public function allMonsterResistances(?MonsterResistanceCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria = new MonsterResistanceCriteria();
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
