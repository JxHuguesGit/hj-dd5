<?php
namespace src\Service;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Skill as DomainSkill;
use src\Repository\SubSkillRepository;

final class SkillService
{
    public function __construct(
        private SubSkillRepository $subSkillRepository,
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
