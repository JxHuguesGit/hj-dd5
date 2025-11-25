<?php
namespace src\Entity;

use src\Constant\Field;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgCondition as RepositoryRpgCondition;

class RpgMonsterCondition extends Entity
{
    public const TABLE = 'rpgMonsterCondition';
    public const FIELDS = [
        Field::ID,
        Field::MONSTERID,
        Field::CONDITIONID,
    ];

    public const FIELD_TYPES = [
        Field::MONSTERID => 'intPositive',
        Field::CONDITIONID => 'intPositive',
    ];

    protected int $monsterId = 0;
    protected int $conditionId = 0;

    private ?RpgMonster $monsterCache = null;
    private ?RpgCondition $conditionCache = null;

    public function getMonster(): ?RpgMonster
    {
        return $this->getRelatedEntity('monsterCache', RepositoryRpgMonster::class, $this->monsterId);
    }

    public function getCondition(): ?RpgCondition
    {
        return $this->getRelatedEntity('conditionCache', RepositoryRpgCondition::class, $this->conditionId);
    }
}
