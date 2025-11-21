<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonsterTypeSpeed as ControllerRpgMonsterTypeSpeed;
use src\Entity\RpgTypeSpeed as EntityRpgTypeSpeed;
use src\Repository\RpgTypeSpeed;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterTypeSpeed extends Entity
{
    public const TABLE = 'rpgMonsterTypeSpeed';
    public const FIELDS = [
        Field::ID,
        Field::MONSTERID,
        Field::TYPESPEEDID,
        Field::VALUE,
        Field::EXTRA,
    ];

    protected int $monsterId;
    protected string $typeSpeedId;
    protected float $value;
    protected string $extra;

    public function getController(): ControllerRpgMonsterTypeSpeed
    {
        $controller = new ControllerRpgMonsterTypeSpeed();
        $controller->setField(self::TABLE, $this);
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
