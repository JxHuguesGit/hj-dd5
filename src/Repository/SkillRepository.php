<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Skill as DomainSkill;

class SkillRepository extends Repository implements SkillRepositoryInterface
{
    public const TABLE = Table::SKILL;

    public function getEntityClass(): string
    {
        return DomainSkill::class;
    }

    public function find(int $id): DomainSkill
    {
        return parent::find($id) ?? new DomainSkill();
    }
}
