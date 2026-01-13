<?php
namespace src\Service;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Skill as DomainSkill;
use src\Repository\SubSkill as RepositorySubSkill;

final class SkillService
{
    public function __construct(
        private RepositorySubSkill $subSkillRepository,
    ) {}

    public function getSubSkills(DomainSkill $skill): Collection
    {
        return $this->subSkillRepository->findBy([
            Field::SKILLID => $skill->id
        ], [
            Field::NAME => Constant::CST_ASC
        ]);
    }
}
