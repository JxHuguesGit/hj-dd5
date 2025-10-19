<?php
namespace src\Entity;

use src\Entity\RpgCondition as EntityRpgCondition;
use src\Repository\RpgCondition;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterCondition extends Entity
{

    public function __construct(
        protected int $id,
        protected int $monsterId,
        protected string $conditionId
    ) {

    }

    public function getCondition(): ?EntityRpgCondition
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgCondition($queryBuilder, $queryExecutor);
        return $objDao->find($this->conditionId);
    }

}