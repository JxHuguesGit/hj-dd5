<?php
namespace src\Repository;

use src\Constant\Table;
use src\Domain\Entity\OriginAbility;

class OriginAbilityRepository extends Repository
{
    public const TABLE = Table::ORIGINABILITY;
    
    public function getEntityClass(): string
    {
        return OriginAbility::class;
    }
}
