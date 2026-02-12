<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterCriteria;
use src\Domain\Entity\Monster;
use src\Repository\MonsterRepositoryInterface;

final class MonsterReader
{
    public function __construct(
        private MonsterRepositoryInterface $monsterRepository
    ) {}

    /**
     * @return ?Monster
     */
    public function originByUkTag(string $ukTag): ?Monster
    {
        $criteria = new MonsterCriteria();
        $criteria->ukTag = $ukTag;
        return $this->monsterRepository->findAllWithCriteria($criteria)?->first() ?? null;
    }

    /**
     * @return Collection<Monster>
     */
    public function allMonsters(?MonsterCriteria $criteria = null): Collection
    {
        if (!$criteria) {
            $criteria = new MonsterCriteria();
        }
        return $this->monsterRepository->findAllWithCriteria($criteria);
    }

}
