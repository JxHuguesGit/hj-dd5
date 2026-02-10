<?php
namespace src\Repository;

use src\Domain\Skill as DomainSkill;
use src\Collection\Collection;
use src\Domain\Criteria\SkillCriteria;

interface SkillRepositoryInterface
{
    /**
     * @return ?DomainSkill
     */
    public function find(int $id): ?DomainSkill;

    /**
     * @return Collection<DomainSkill>
     */
    public function findAllWithCriteria(SkillCriteria $criteria): Collection;
}
