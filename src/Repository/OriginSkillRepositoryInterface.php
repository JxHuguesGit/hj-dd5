<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\OriginSkillCriteria;
use src\Domain\Entity\OriginSkill;

interface OriginSkillRepositoryInterface
{

    /**
     * @return Collection<OriginSkill>
     */
    public function findAllWithCriteria(OriginSkillCriteria $criteria): Collection;
}
