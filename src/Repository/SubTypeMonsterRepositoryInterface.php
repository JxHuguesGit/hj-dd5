<?php
namespace src\Repository;

use src\Domain\Criteria\SubTypeMonsterCriteria;
use src\Domain\Entity\SubTypeMonster;
use src\Collection\Collection;

interface SubTypeMonsterRepositoryInterface
{
    /**
    * @return ?SubTypeMonster
    */
    public function find(int $id): ?SubTypeMonster;

    /**
     * @return Collection<SubTypeMonster>
     */
    public function findAllWithCriteria(SubTypeMonsterCriteria $criteria): Collection;
}
