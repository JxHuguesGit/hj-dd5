<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Skill as DomainSkill;

class Skill extends Repository
{
    public const TABLE = Table::SKILL;

    public function getEntityClass(): string
    {
        return DomainSkill::class;
    }
}
