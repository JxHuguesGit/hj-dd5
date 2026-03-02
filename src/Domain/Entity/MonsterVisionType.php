<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterVisionType extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::MONSTERID,
        Field::TYPEVISIONID,
        Field::VALUE,
        Field::EXTRA,
    ];

    public const FIELD_TYPES = [
        Field::MONSTERID    => FieldType::INTPOSITIVE,
        Field::TYPEVISIONID => FieldType::INTPOSITIVE,
        Field::VALUE        => FieldType::FLOAT,
        Field::EXTRA        => FieldType::STRING,
    ];
}
