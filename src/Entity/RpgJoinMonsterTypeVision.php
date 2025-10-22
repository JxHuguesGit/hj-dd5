<?php
namespace src\Entity;

use src\Controller\RpgJoinMonsterTypeVision as ControllerRpgJoinMonsterTypeVision;
use src\Entity\RpgTypeVision as EntityRpgTypeVision;
use src\Repository\RpgTypeVision;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgJoinMonsterTypeVision extends Entity
{

    public function __construct(
        protected int $id,
        protected int $monsterId,
        protected string $typeVisionId,
        protected int $value,
        protected string $extra
    ) {

    }

    public function getController(): ControllerRpgJoinMonsterTypeVision
    {
        $controller = new ControllerRpgJoinMonsterTypeVision();
        $controller->setField('rpgJoinMonsterTypeVision', $this);
        return $controller;
    }

    public function getTypeVision(): ?EntityRpgTypeVision
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgTypeVision($queryBuilder, $queryExecutor);
        return $objDao->find($this->typeVisionId);
    }
}
