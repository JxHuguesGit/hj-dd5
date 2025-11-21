<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonsterResistance as ControllerRpgMonsterResistance;
use src\Entity\RpgCondition as EntityRpgCondition;
use src\Entity\RpgTypeDamage as EntityRpgTypeDamage;
use src\Repository\RpgCondition;
use src\Repository\RpgTypeDamage;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterResistance extends Entity
{
    public const TABLE = 'rpgMonsterResistance';
    public const FIELDS = [
        Field::ID,
        Field::MONSTERID,
        Field::TYPEDMGID,
        Field::TYPERESID,
    ];

    protected int $monsterId;
    protected string $typeDamageId;
    protected string $typeResistanceId;

    public function getController(): ControllerRpgMonsterResistance
    {
        $controller = new ControllerRpgMonsterResistance();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function getTypeDamage(): ?EntityRpgTypeDamage
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgTypeDamage($queryBuilder, $queryExecutor);
        return $objDao->find($this->typeDamageId);
    }

    public function getTypeCondition(): ?EntityRpgCondition
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgCondition($queryBuilder, $queryExecutor);
        return $objDao->find($this->typeDamageId);
    }

}
