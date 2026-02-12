<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MonsterCriteria;
use src\Domain\Entity\Monster;

class MonsterRepository extends Repository implements MonsterRepositoryInterface
{
    public const TABLE = Table::MONSTER;

    public function getEntityClass(): string
    {
        return Monster::class;
    }

    /**
     * @return Collection<Monster>
     */
    public function findAllWithCriteria(
        MonsterCriteria $criteria
    ): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
