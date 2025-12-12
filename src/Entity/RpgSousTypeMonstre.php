<?php
namespace src\Entity;

use src\Constant\Field;
use src\Repository\RpgTypeMonstre as RepositoryRpgTypeMonster;

class RpgSousTypeMonstre extends Entity
{
    public const TABLE = 'rpgMonsterSubType';
    public const FIELDS = [
        Field::ID,
        Field::MSTTYPEID,
        Field::NAME,
    ];

    public const FIELD_TYPES = [
        Field::MSTTYPEID => 'intPositive',
        Field::NAME => 'string',
    ];

    private const TRANSLATIONS = [
        'Chromatic' => 'Chromatique',
        'Metallic'  => 'Métallique',
        'Dinosaur'  => 'Dinosaure',
        'Wizard'    => 'Magicien',
        'Cleric'    => 'Clerc',
        'Demon'     => 'Démon',
        'Devil'     => 'Diable',
        'Goblinoid' => 'Goblinoïde',
        'Genie'     => 'Génie',
        'Angel'     => 'Ange',
    ];

    protected int $monstreTypeId = 0;
    protected string $name = '';

    public function stringify(): string
    {
        return $this->getStrName();
    }

    public function getMonsterType(): ?RpgTypeMonstre
    {
        return $this->getRelatedEntity('monstreTypeCache', RepositoryRpgTypeMonster::class, $this->monstreTypeId);
    }

    public function getStrName(): string
    {
        return self::TRANSLATIONS[$this->name] ?? $this->name ?? 'Type de monstre non identifié';
    }
}
