<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MonsterResistanceCriteria;
use src\Domain\Entity\MonsterResistance;

class MonsterResistanceRepository extends Repository implements MonsterResistanceRepositoryInterface
{
    public const TABLE = Table::MSTRESISTANCE;

    public function getEntityClass(): string
    {
        return MonsterResistance::class;
    }

    /**
     * @return Collection<MonsterResistance>
     */
    public function findAllWithCriteria(MonsterResistanceCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
