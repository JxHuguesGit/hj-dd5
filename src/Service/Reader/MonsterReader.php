<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Criteria\MonsterCriteria;
use src\Repository\MonsterRepositoryInterface;

final class MonsterReader
{
    public function __construct(
        private MonsterRepositoryInterface $monsterRepository
    ) {}
    
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
