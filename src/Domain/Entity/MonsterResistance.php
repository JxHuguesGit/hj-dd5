<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterResistance extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::MONSTERID,
        Field::TYPEDMGID,
        Field::TYPERESID,
    ];

    public const FIELD_TYPES = [
        Field::MONSTERID => FieldType::INTPOSITIVE,
        Field::TYPEDMGID => FieldType::INTPOSITIVE,
        Field::TYPERESID => FieldType::STRING,
    ];
}
