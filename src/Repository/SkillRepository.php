<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SkillCriteria;
use src\Domain\Skill as DomainSkill;

class SkillRepository extends Repository implements SkillRepositoryInterface
{
    public const TABLE = Table::SKILL;

    public function getEntityClass(): string
    {
        return DomainSkill::class;
    }

    /**
     * @return DomainSkill
     */
    public function find(int $id): DomainSkill
    {
        return parent::find($id) ?? new DomainSkill();
    }

    /**
     * @return Collection<DomainSkill>
     */
    public function findAllWithCriteria(
        SkillCriteria $criteria
    ): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
