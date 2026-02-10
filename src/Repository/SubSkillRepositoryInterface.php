<?php
namespace src\Repository;

use src\Domain\SubSkill as DomainSubSkill;
use src\Collection\Collection;

interface SubSkillRepositoryInterface
{
    /**
     * @return ?DomainSubSkill
     */
    public function find(int $id): ?DomainSubSkill;
}
