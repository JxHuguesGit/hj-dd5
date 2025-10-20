<?php
namespace src\Entity;

use src\Controller\RpgJoinMonsterTypeSpeed as ControllerRpgJoinMonsterTypeSpeed;
use src\Entity\RpgTypeSpeed as EntityRpgTypeSpeed;
use src\Repository\RpgTypeSpeed;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgJoinMonsterTypeSpeed extends Entity
{

    public function __construct(
        protected int $id,
        protected int $monsterId,
        protected string $typeSpeedId,
        protected float $value,
        protected string $extra
    ) {

    }

    public function getController(): ControllerRpgJoinMonsterTypeSpeed
    {
        $controller = new ControllerRpgJoinMonsterTypeSpeed();
        $controller->setField('rpgJoinMonsterTypeSpeed', $this);
        return $controller;
    }

    public function getTypeSpeed(): ?EntityRpgTypeSpeed
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgTypeSpeed($queryBuilder, $queryExecutor);
        return $objDao->find($this->typeSpeedId);
    }
}
