<?php
namespace src\Repository;

use src\Domain\Entity\SubSkill;

interface SubSkillRepositoryInterface
{
    /**
     * @return ?SubSkill
     */
    public function find(int $id): ?SubSkill;
}
