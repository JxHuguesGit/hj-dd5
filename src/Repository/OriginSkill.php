<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Entity\OriginSkill as DomainOriginSkill;

class OriginSkill extends Repository
{
    public const TABLE = Table::ORIGINSKILL;
    
    public function getEntityClass(): string
    {
        return DomainOriginSkill::class;
    }
}
