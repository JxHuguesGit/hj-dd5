<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterResistance extends Entity
{
    public const FIELDS = [
        F::ID,
        F::MONSTERID,
        F::TYPEDMGID,
        F::TYPERESID,
    ];

    public const FIELD_TYPES = [
        F::MONSTERID => FieldType::INTPOSITIVE,
        F::TYPEDMGID => FieldType::INTPOSITIVE,
        F::TYPERESID => FieldType::STRING,
    ];
}
