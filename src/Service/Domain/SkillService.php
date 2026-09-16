<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Domain\Criteria\OriginSkillCriteria;
use src\Domain\Entity\Skill;
use src\Service\Reader\OriginReader;
use src\Service\Reader\OriginSkillReader;

final class SkillService
{
    public function __construct(
        private OriginSkillReader $originSkillReader,
        private OriginReader $originReader,
    ) {}

    public function getOrigines(?Skill $skill): Collection
    {
        $criteria          = new OriginSkillCriteria();
        $criteria->skillId = $skill->id;
        $originSkills      = $this->originSkillReader->allOriginSkills($criteria);

        $collection = new Collection();
        foreach ($originSkills as $originSkill) {
            $originId = $originSkill->originId;
            $origin   = $this->originReader->originById($originId);
            $collection->add($origin);
        }
        return $collection;
    }
}
