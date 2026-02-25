<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\SubSkillCriteria;
use src\Domain\Entity\SubSkill;

class SubSkillRepository extends Repository implements SubSkillRepositoryInterface
{
    public const TABLE = Table::SUBSKILL;

    public function getEntityClass(): string
    {
        return SubSkill::class;
    }

    /**
     * @return ?SubSkill
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?SubSkill
    {
        return parent::find($id);
    }

    /**
     * @return Collection<SubSkill>
     */
    public function findAllWithCriteria(SubSkillCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
