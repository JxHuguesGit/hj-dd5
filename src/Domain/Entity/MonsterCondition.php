<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterCondition extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::MONSTERID,
        Field::CONDITIONID,
    ];

    public const FIELD_TYPES = [
        Field::MONSTERID   => FieldType::INTPOSITIVE,
        Field::CONDITIONID => FieldType::INTPOSITIVE,
    ];
}
