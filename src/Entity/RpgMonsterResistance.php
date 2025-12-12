<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonsterResistance as ControllerRpgMonsterResistance;
use src\Repository\RpgCondition as RepositoryRpgCondition;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgTypeDamage as RepositoryRpgTypeDamage;
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
    
    public const FIELD_TYPES = [
        Field::MONSTERID => 'intPositive',
        Field::TYPEDMGID => 'intPositive',
        Field::TYPERESID => 'string',
    ];
    
    protected int $monsterId = 0;
    protected int $typeDamageId = 0;
    protected string $typeResistanceId = '';

    // TODO : à externaliser
    public function getController(): ControllerRpgMonsterResistance
    {
        $controller = new ControllerRpgMonsterResistance();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function getMonster(): ?RpgMonster
    {
        return $this->getRelatedEntity('monsterCache', RepositoryRpgMonster::class, $this->monsterId);
    }

    public function getTypeDamage(): ?RpgTypeDamage
    {
        return $this->getRelatedEntity('typeDamageCache', RepositoryRpgTypeDamage::class, $this->typeDamageId);
    }

    public function getTypeCondition(): ?RpgCondition
    {
        return $this->getRelatedEntity('conditionCache', RepositoryRpgCondition::class, $this->typeDamageId);
    }
}
