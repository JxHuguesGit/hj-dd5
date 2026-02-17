<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterSpeedTypeCriteria;

interface MonsterSpeedTypeRepositoryInterface
{
    /**
     * @return Collection<MonsterSpeed>
     */
    public function findAllWithCriteria(MonsterSpeedTypeCriteria $criteria): Collection;
}
