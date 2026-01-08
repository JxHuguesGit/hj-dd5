<?php
namespace src\Service;

use src\Collection\Collection;
use src\Domain\RpgSkill as DomainRpgSkill;
use src\Repository\RpgSkill as RepositoryRpgSkill;

final class RpgSkillQueryService
{
    public function __construct(
        private RepositoryRpgSkill $skillRepository
    ) {}
    
    public function getAllSkills(array $orderBy=[]): Collection
    {
        return $this->skillRepository->findAll($orderBy);
    }
    
    public function getSkill(int $id): ?DomainRpgSkill
    {
        return $this->skillRepository->find($id);
    }
}
