<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonsterSkill as ControllerRpgMonsterSkill;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgSkill as RepositoryRpgSkill;
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
    public const FIELD_TYPES = [
        Field::MONSTERID => 'intPositive',
        Field::SKILLID => 'intPositive',
        Field::VALUE => 'int',
    ];
    
    protected int $monsterId = 0;
    protected int $skillId = 0;
    protected int $value = 0;

    // TODO : à externaliser
    public function getController(): ControllerRpgMonsterSkill
    {
        $controller = new ControllerRpgMonsterSkill();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function getMonster(): ?RpgMonster
    {
        return $this->getRelatedEntity('monsterCache', RepositoryRpgMonster::class, $this->monsterId);
    }

    public function getSkill(): ?RpgSkill
    {
        return $this->getRelatedEntity('skillCache', RepositoryRpgSkill::class, $this->skillId);
    }
}
