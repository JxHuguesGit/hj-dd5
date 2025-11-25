<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonsterTypeSpeed as ControllerRpgMonsterTypeSpeed;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgTypeSpeed as RepositoryRpgTypeSpeed;

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
    public const FIELD_TYPES = [
        Field::MONSTERID => 'intPositive',
        Field::TYPESPEEDID => 'intPositive',
        Field::VALUE => 'float',
        Field::EXTRA => 'string',
    ];
    
    protected int $monsterId = 0;
    protected int $typeSpeedId = 0;
    protected float $value = 0.0;
    protected string $extra = '';

    private ?RpgMonster $monsterCache = null;
    private ?RpgTypeSpeed $speedTypeCache = null;

    // TODO : à externaliser
    public function getController(): ControllerRpgMonsterTypeSpeed
    {
        $controller = new ControllerRpgMonsterTypeSpeed();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function getMonster(): ?RpgMonster
    {
        return $this->getRelatedEntity('monsterCache', RepositoryRpgMonster::class, $this->monsterId);
    }

    public function getTypeSpeed(): ?RpgTypeSpeed
    {
        return $this->getRelatedEntity('speedTypeCache', RepositoryRpgTypeSpeed::class, $this->typeSpeedId);
    }
}
