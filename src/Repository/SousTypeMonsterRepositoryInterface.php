<?php
namespace src\Repository;

use src\Domain\Criteria\SousTypeMonsterCriteria;
use src\Domain\Entity\SousTypeMonster;
use src\Collection\Collection;

interface SousTypeMonsterRepositoryInterface
{

    /**
     * @return Collection<SousTypeMonster>
     */
    public function findAllWithCriteria(SousTypeMonsterCriteria $criteria): Collection;
}
