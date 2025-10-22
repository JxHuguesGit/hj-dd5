<?php
namespace src\Entity;

use src\Controller\RpgMonsterSkill as ControllerRpgMonsterSkill;
use src\Entity\RpgSkill as EntityRpgSkill;
use src\Repository\RpgSkill;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterSkill extends Entity
{

    public function __construct(
        protected int $id,
        protected int $monsterId,
        protected int $skillId,
        protected int $value
    ) {

    }

    public function getController(): ControllerRpgMonsterSkill
    {
        $controller = new ControllerRpgMonsterSkill();
        $controller->setField('rpgMonsterSkill', $this);
        return $controller;
    }
    
    public function getSkill(): ?EntityRpgSkill
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgSkill($queryBuilder, $queryExecutor);
        return $objDao->find($this->skillId);
    }
}
