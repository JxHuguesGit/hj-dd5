<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonsterTypeVision as ControllerRpgMonsterTypeVision;
use src\Repository\RpgMonster as RepositoryRpgMonster;
use src\Repository\RpgTypeVision as RepositoryRpgTypeVision;

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
    public const FIELD_TYPES = [
        Field::MONSTERID => 'intPositive',
        Field::TYPEVISIONID => 'intPositive',
        Field::VALUE => 'float',
        Field::EXTRA => 'string',
    ];
    
    protected int $monsterId = 0;
    protected int $typeVisionId = 0;
    protected float $value = 0;
    protected string $extra = '';
    
    // TODO : à externaliser
    public function getController(): ControllerRpgMonsterTypeVision
    {
        $controller = new ControllerRpgMonsterTypeVision();
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function getMonster(): ?RpgMonster
    {
        return $this->getRelatedEntity('monsterCache', RepositoryRpgMonster::class, $this->monsterId);
    }

    public function getTypeVision(): ?RpgTypeVision
    {
        return $this->getRelatedEntity('visionTypeCache', RepositoryRpgTypeVision::class, $this->typeVisionId);
    }
}
