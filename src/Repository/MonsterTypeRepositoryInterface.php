<?php
namespace src\Repository;

use src\Domain\Criteria\MonsterTypeCriteria;
use src\Domain\Entity\MonsterType;
use src\Collection\Collection;

interface MonsterTypeRepositoryInterface
{
    /**
    * @return ?MonsterType
    */
    public function find(int $id): ?MonsterType;
    
    /**
     * @return Collection<MonsterType>
     */
    public function findAllWithCriteria(MonsterTypeCriteria $criteria): Collection;
}
