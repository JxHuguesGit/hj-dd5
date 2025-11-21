<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonsterTypeVision as ControllerRpgMonsterTypeVision;
use src\Entity\RpgTypeVision as EntityRpgTypeVision;
use src\Repository\RpgTypeVision;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterTypeVision extends Entity
{
    public const TABLE = 'rpgMonsterTypeVision';
    public const FIELDS = [
        Field::ID,
        Field::MONSTERID,
        Field::TYPEVISIONID,
        Field::VALUE,
        Field::EXTRA,
    ];

    protected int $monsterId;
    protected string $typeVisionId;
    protected int $value;
    protected string $extra;

    public function getController(): ControllerRpgMonsterTypeVision
    {
        $controller = new ControllerRpgMonsterTypeVision();
        $controller->setField(self::TABLE, $this);
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
