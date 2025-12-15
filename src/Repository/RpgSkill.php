<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\RpgSkill as DomainRpgSkill;

class RpgSkill extends Repository
{
    public const TABLE = Table::SKILL;

    public function getEntityClass(): string
    {
        return DomainRpgSkill::class;
    }
}
