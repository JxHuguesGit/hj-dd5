<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonsterSkill as ControllerRpgMonsterSkill;
use src\Entity\RpgSkill as EntityRpgSkill;
use src\Repository\RpgSkill;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;

class RpgMonsterSkill extends Entity
{
    public const TABLE = 'rpgMonsterSkill';
    public const FIELDS = [
        Field::ID,
        Field::MONSTERID,
        Field::SKILLID,
        Field::VALUE,
    ];

    protected int $monsterId;
    protected int $skillId;
    protected int $value;

    public function getController(): ControllerRpgMonsterSkill
    {
        $controller = new ControllerRpgMonsterSkill();
        $controller->setField(self::TABLE, $this);
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
