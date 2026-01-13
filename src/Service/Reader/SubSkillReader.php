<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\SubSkill as DomainSubSkill;
use src\Repository\SubSkill as RepositorySubSkill;

final class SubSkillReader
{
    public function __construct(
        private RepositorySubSkill $subSkillRepository
    ) {}
    
    public function getAllSubSkills(array $orderBy=[]): Collection
    {
        return $this->subSkillRepository->findAll($orderBy);
    }

    public function getSubSkill(int $id): ?DomainSubSkill
    {
        return $this->subSkillRepository->find($id);
    }
}
