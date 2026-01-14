<?php
namespace src\Repository;

use src\Domain\Skill as DomainSkill;
use src\Collection\Collection;

interface SkillRepositoryInterface
{
    public function find(int $id): ?DomainSkill;
    /**
     * @return Collection<DomainSkill>
     */
    public function findAll(array $orderBy = []): Collection;
}
