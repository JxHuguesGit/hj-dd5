<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\MonsterSkillCriteria;
use src\Domain\Entity\MonsterSkill;

class MonsterSkillRepository extends Repository implements MonsterSkillRepositoryInterface
{
    public const TABLE = Table::MSTSKILL;

    public function getEntityClass(): string
    {
        return MonsterSkill::class;
    }

    /**
     * @return Collection<MonsterSkill>
     */
    public function findAllWithCriteria(MonsterSkillCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
