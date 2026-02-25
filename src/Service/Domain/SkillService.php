<?php
namespace src\Service\Domain;

use src\Collection\Collection;
use src\Domain\Criteria\OriginSkillCriteria;
use src\Domain\Criteria\SubSkillCriteria;
use src\Domain\Entity\Skill;
use src\Domain\Entity\SubSkill;
use src\Service\Reader\OriginReader;
use src\Service\Reader\OriginSkillReader;
use src\Service\Reader\SubSkillReader;

final class SkillService
{
    public function __construct(
        private OriginSkillReader $originSkillReader,
        private SubSkillReader $subSkillReader,
        private OriginReader $originReader,
    ) {}

    /**
     * @return Collection<SubSkill>
     */
    public function subSkills(Skill $skill): Collection
    {
        $criteria          = new SubSkillCriteria();
        $criteria->skillId = $skill->id;
        return $this->subSkillReader->allSubSkills($criteria);
    }

    public function getOrigines(Skill $skill): Collection
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
