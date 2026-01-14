<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Skill as DomainSkill;
use src\Repository\SkillRepositoryInterface;

final class SkillReader
{
    public function __construct(
        private SkillRepositoryInterface $skillRepository
    ) {}
    
    /**
     * @return Collection<DomainSkill>
     */
    public function allSkills(array $orderBy=[]): Collection
    {
        return $this->skillRepository->findAll($orderBy);
    }
    
    public function skillById(int $id): ?DomainSkill
    {
        return $this->skillRepository->find($id);
    }
}
