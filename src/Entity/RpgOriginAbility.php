<?php
namespace src\Entity;

use src\Constant\Field;
use src\Entity\RpgAbility as EntityRpgAbility;
use src\Repository\RpgAbility;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgOriginAbility extends Entity
{
    public const TABLE = 'rpgOriginAbility';
    public const FIELDS = [
        Field::ID,
        Field::ORIGINID,
        Field::ABILITYID,
    ];

    protected int $originId;
    protected int $abilityId;
    
    public function getAbility(): ?EntityRpgAbility
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgAbility($queryBuilder, $queryExecutor);
        return $objDao->find($this->abilityId);
    }
}
