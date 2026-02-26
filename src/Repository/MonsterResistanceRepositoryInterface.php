<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterResistanceCriteria;
use src\Domain\Entity\MonsterResistance;

interface MonsterResistanceRepositoryInterface
{
    /**
     * @return Collection<MonsterResistance>
     */
    public function findAllWithCriteria(MonsterResistanceCriteria $criteria): Collection;
}
