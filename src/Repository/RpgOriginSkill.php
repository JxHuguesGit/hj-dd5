<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\RpgOriginSkill as DomainRpgOriginSkill;

class RpgOriginSkill extends Repository
{
    public const TABLE = Table::ORIGINSKILL;
    
    public function getEntityClass(): string
    {
        return DomainRpgOriginSkill::class;
    }
}
