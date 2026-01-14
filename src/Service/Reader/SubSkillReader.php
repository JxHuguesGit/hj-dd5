<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\SubSkill as DomainSubSkill;
use src\Repository\SubSkillRepositoryInterface;

final class SubSkillReader
{
    public function __construct(
        private SubSkillRepositoryInterface $subSkillRepository
    ) {}
    
    /**
     * @return Collection<DomainSubSkill>
     */
    public function allSubSkills(array $orderBy=[]): Collection
    {
        return $this->subSkillRepository->findAll($orderBy);
    }

    public function subSkillById(int $id): ?DomainSubSkill
    {
        return $this->subSkillRepository->find($id);
    }
}
