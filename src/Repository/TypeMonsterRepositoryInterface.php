<?php
namespace src\Repository;

use src\Domain\Criteria\TypeMonsterCriteria;
use src\Domain\Entity\TypeMonster;
use src\Collection\Collection;

interface TypeMonsterRepositoryInterface
{
    /**
     * @return Collection<TypeMonster>
     */
    public function findAllWithCriteria(TypeMonsterCriteria $criteria): Collection;
}
