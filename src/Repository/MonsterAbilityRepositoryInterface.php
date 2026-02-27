<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterAbilityCriteria;
use src\Domain\Entity\MonsterAbility;

interface MonsterAbilityRepositoryInterface
{
    /**
     * @return Collection<MonsterAbility>
     */
    public function findAllWithCriteria(MonsterAbilityCriteria $criteria): Collection;
}
