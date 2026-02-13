<?php
namespace src\Repository;

use src\Constant\Table;
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
}
