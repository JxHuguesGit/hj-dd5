<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterVisionType extends Entity
{
    public const FIELDS = [
        F::ID,
        F::MONSTERID,
        F::TYPEVISIONID,
        F::VALUE,
        F::EXTRA,
    ];

    public const FIELD_TYPES = [
        F::MONSTERID    => FieldType::INTPOSITIVE,
        F::TYPEVISIONID => FieldType::INTPOSITIVE,
        F::VALUE        => FieldType::FLOAT,
        F::EXTRA        => FieldType::STRING,
    ];
}
