<?php
namespace src\Service\Skill;

use src\Collection\Collection;
use src\Domain\Skill as DomainSkill;
use src\Repository\Skill as RepositorySkill;

final class SkillReader
{
    public function __construct(
        private RepositorySkill $skillRepository
    ) {}
    
    public function getAllSkills(array $orderBy=[]): Collection
    {
        return $this->skillRepository->findAll($orderBy);
    }
    
    public function getSkill(int $id): ?DomainSkill
    {
        return $this->skillRepository->find($id);
    }
}
