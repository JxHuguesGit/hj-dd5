<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\MonsterSkillCriteria;

interface MonsterSkillRepositoryInterface
{
    /**
     * @return Collection<MonsterSkill>
     */
    public function findAllWithCriteria(MonsterSkillCriteria $criteria): Collection;
}
