<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Entity\Skill;
use src\Repository\OriginSkillRepository;
use src\Repository\SubSkillRepository;
use src\Service\Reader\OriginReader;

final class SkillService
{
    public function __construct(
        private OriginSkillRepository $originSkillRepository,
        private SubSkillRepository $subSkillRepository,
        private OriginReader $originReader,
    ) {}

    public function subSkills(Skill $skill): Collection
    {
        return $this->subSkillRepository->findBy([
            Field::SKILLID => $skill->id
        ], [
            Field::NAME => Constant::CST_ASC
        ]);
    }

    public function getOrigines(Skill $skill): Collection
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
