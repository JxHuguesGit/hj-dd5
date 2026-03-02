<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterVisionTypeCriteria;

interface MonsterVisionTypeRepositoryInterface
{
    /**
     * @return Collection<MonsterSpeed>
     */
    public function findAllWithCriteria(MonsterVisionTypeCriteria $criteria): Collection;
}
