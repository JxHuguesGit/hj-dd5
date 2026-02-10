<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SkillCriteria;
use src\Domain\Entity\Skill;

class SkillRepository extends Repository implements SkillRepositoryInterface
{
    public const TABLE = Table::SKILL;

    public function getEntityClass(): string
    {
        return Skill::class;
    }

    /**
     * @return Skill
     */
    public function find(int $id): Skill
    {
        return parent::find($id) ?? new Skill();
    }

    /**
     * @return Collection<Skill>
     */
    public function findAllWithCriteria(
        SkillCriteria $criteria
    ): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
