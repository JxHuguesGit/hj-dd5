<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\SubSkill as DomainSubSkill;

class SubSkill extends Repository
{
    public const TABLE = Table::SUBSKILL;

    public function getEntityClass(): string
    {
        return DomainSubSkill::class;
    }
}
