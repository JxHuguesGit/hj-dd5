<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\OriginSkillCriteria;
use src\Domain\Entity\OriginSkill;

class OriginSkillRepository extends Repository implements OriginSkillRepositoryInterface
{
    public const TABLE = Table::ORIGINSKILL;

    public function getEntityClass(): string
    {
        return OriginSkill::class;
    }

    /**
     * @return Collection<OriginSkill>
     */
    public function findAllWithCriteria(OriginSkillCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
