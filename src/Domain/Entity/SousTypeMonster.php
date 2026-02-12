<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

class SousTypeMonster extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::MSTTYPEID,
        Field::NAME,
    ];

    public const FIELD_TYPES = [
        Field::MSTTYPEID => FieldType::INTPOSITIVE,
        Field::NAME => FieldType::STRING,
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

    public function stringify(): string
    {
        return $this->getStrName();
    }

    public function getStrName(): string
    {
        return self::TRANSLATIONS[$this->name] ?? $this->name ?? 'Type de monstre non identifié';
    }
}
