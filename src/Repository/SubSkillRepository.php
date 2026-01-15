<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\SubSkill as DomainSubSkill;

class SubSkillRepository extends Repository implements SubSkillRepositoryInterface
{
    public const TABLE = Table::SUBSKILL;

    public function getEntityClass(): string
    {
        return DomainSubSkill::class;
    }

    public function find(int $id): DomainSubSkill
    {
        return parent::find($id) ?? new DomainSubSkill();
    }
}
