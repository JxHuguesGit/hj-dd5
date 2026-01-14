<?php
namespace src\Repository;

use src\Domain\SubSkill as DomainSubSkill;
use src\Collection\Collection;

interface SubSkillRepositoryInterface
{
    public function find(int $id): ?DomainSubSkill;
    /**
     * @return Collection<DomainSubSkill>
     */
    public function findAll(array $orderBy = []): Collection;
}
