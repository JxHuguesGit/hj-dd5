<?php
namespace src\Entity;

use src\Controller\RpgMonsterResistance as ControllerRpgMonsterResistance;
use src\Entity\RpgTypeDamage as EntityRpgTypeDamage;
use src\Repository\RpgTypeDamage;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterResistance extends Entity
{

    public function __construct(
        protected int $id,
        protected int $monsterId,
        protected string $typeDamageId,
        protected string $typeResistanceId
    ) {

    }

    public function getController(): ControllerRpgMonsterResistance
    {
        $controller = new ControllerRpgMonsterResistance();
        $controller->setField('rpgMonsterResistance', $this);
        return $controller;
    }

    public function getTypeDamage(): ?EntityRpgTypeDamage
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgTypeDamage($queryBuilder, $queryExecutor);
        return $objDao->find($this->typeDamageId);
    }

}
