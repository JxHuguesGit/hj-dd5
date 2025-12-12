<?php
namespace src\Entity;

use src\Constant\Field;
use src\Controller\RpgMonsterLanguage as ControllerRpgMonsterLanguage;
use src\Repository\RpgLanguage as RepositoryRpgLanguage;
use src\Repository\RpgMonster as RepositoryRpgMonster;

class RpgMonsterLanguage extends Entity
{
    public const TABLE = 'rpgMonsterLanguage';
    public const FIELDS = [
        Field::ID,
        Field::MONSTERID,
        Field::LANGUAGEID,
        Field::VALUE,
    ];

    public const FIELD_TYPES = [
        Field::MONSTERID => 'intPositive',
        Field::LANGUAGEID => 'intPositive',
        Field::VALUE => 'float',
    ];
    
    protected int $monsterId;
    protected int $languageId;
    protected float $value;
    
    // TODO : à externaliser
    public function getController(): ControllerRpgMonsterLanguage
    {
        $obj = new ControllerRpgMonsterLanguage();
        $obj->setField(self::TABLE, $this);
        return $obj;
    }

    public function getMonster(): ?RpgMonster
    {
        return $this->getRelatedEntity('monsterCache', RepositoryRpgMonster::class, $this->monsterId);
    }

    public function getLanguage(): ?RpgLanguage
    {
        return $this->getRelatedEntity('languageCache', RepositoryRpgLanguage::class, $this->languageId);
    }
}
