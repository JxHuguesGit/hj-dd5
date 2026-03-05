<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterCondition extends Entity
{
    public const FIELDS = [
        F::ID,
        F::MONSTERID,
        F::CONDITIONID,
    ];

    public const FIELD_TYPES = [
        F::MONSTERID   => FieldType::INTPOSITIVE,
        F::CONDITIONID => FieldType::INTPOSITIVE,
    ];
}
