<?php
namespace src\Repository;

use src\Domain\Entity\Skill;
use src\Collection\Collection;
use src\Domain\Criteria\SkillCriteria;

interface SkillRepositoryInterface
{
    /**
     * @return ?Skill
     */
    public function find(int $id): ?Skill;

    /**
     * @return Collection<Skill>
     */
    public function findAllWithCriteria(SkillCriteria $criteria): Collection;
}
