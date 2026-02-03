<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Skill as DomainSkill;
use src\Repository\OriginSkill as RepositoryOriginSkill;
use src\Repository\SubSkillRepository;
use src\Service\Reader\OriginReader;

final class SkillService
{
    public function __construct(
        private RepositoryOriginSkill $originSkillRepository,
        private SubSkillRepository $subSkillRepository,
        private OriginReader $originReader,
    ) {}

    public function subSkills(DomainSkill $skill): Collection
    {
        return $this->subSkillRepository->findBy([
            Field::SKILLID => $skill->id
        ], [
            Field::NAME => Constant::CST_ASC
        ]);
    }

    public function getOrigines(DomainSkill $skill): Collection
    {
        $originSkills = $this->originSkillRepository->findBy([
            Field::SKILLID => $skill->id
        ]);

        $collection = new Collection();
        foreach ($originSkills as $originSkill) {
            $originId = $originSkill->originId;
            $origin = $this->originReader->originById($originId);
            $collection->add($origin);
        }
        return $collection;
    }
}
