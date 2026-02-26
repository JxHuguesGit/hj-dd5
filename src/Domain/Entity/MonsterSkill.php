<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterSkill extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::MONSTERID,
        Field::SKILLID,
        Field::VALUE,
    ];

    public const FIELD_TYPES = [
        Field::MONSTERID => FieldType::INTPOSITIVE,
        Field::SKILLID   => FieldType::INTPOSITIVE,
        Field::VALUE     => FieldType::FLOAT,
    ];
}
