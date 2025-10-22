<?php
namespace src\Entity;

use src\Controller\RpgMonsterTypeVision as ControllerRpgMonsterTypeVision;
use src\Entity\RpgTypeVision as EntityRpgTypeVision;
use src\Repository\RpgTypeVision;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterTypeVision extends Entity
{

    public function __construct(
        protected int $id,
        protected int $monsterId,
        protected string $typeVisionId,
        protected int $value,
        protected string $extra
    ) {

    }

    public function getController(): ControllerRpgMonsterTypeVision
    {
        $controller = new ControllerRpgMonsterTypeVision();
        $controller->setField('rpgMonsterTypeVision', $this);
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
