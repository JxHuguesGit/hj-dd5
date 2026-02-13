<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterCriteria;
use src\Domain\Monster\Monster;
use src\Repository\MonsterRepositoryInterface;

final class MonsterReader
{
    public function __construct(
        private MonsterRepositoryInterface $monsterRepository
    ) {}

    /**
     * @return ?Monster
     */
    public function monsterByUkTag(string $ukTag): ?Monster
    {
        $criteria = new MonsterCriteria();
        $criteria->ukTag = $ukTag;
        return $this->monsterRepository->findAllWithRelations($criteria)?->first() ?? null;
    }

    /**
     * @return Collection<Monster>
     */
    public function allMonsters(?MonsterCriteria $criteria = null): Collection
    {
        if (!$criteria) {
            $criteria = new MonsterCriteria();
            $criteria->limit = 10;
        }
        return $this->monsterRepository->findAllWithRelations($criteria);
    }

}
