<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Criteria\SubSkillCriteria;
use src\Domain\Entity\SubSkill;
use src\Repository\SubSkillRepositoryInterface;

final class SubSkillReader
{
    public function __construct(
        private SubSkillRepositoryInterface $repository,
    ) {}

    /**
     * @return ?SubSkill
     */
    public function subSkillById(int $id): ?SubSkill
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<SubSkill>
     */
    public function allSubSkills(?SubSkillCriteria $criteria = null): Collection
    {
        if (! $criteria) {
            $criteria          = new SubSkillCriteria();
            $criteria->orderBy = [Field::NAME => Constant::CST_ASC];
        }
        return $this->repository->findAllWithCriteria($criteria);
    }
}
