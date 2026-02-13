<?php
namespace src\Repository;

use src\Domain\Criteria\MonsterSubTypeCriteria;
use src\Domain\Entity\MonsterSubType;
use src\Collection\Collection;

interface MonsterSubTypeRepositoryInterface
{
    /**
    * @return ?MonsterSubType
    */
    public function find(int $id): ?MonsterSubType;

    /**
     * @return Collection<MonsterSubType>
     */
    public function findAllWithCriteria(MonsterSubTypeCriteria $criteria): Collection;
}
