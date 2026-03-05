<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterSpeedType extends Entity
{
    public const FIELDS = [
        F::ID,
        F::MONSTERID,
        F::TYPESPEEDID,
        F::VALUE,
        F::EXTRA
    ];

    public const FIELD_TYPES = [
        F::MONSTERID   => FieldType::INTPOSITIVE,
        F::TYPESPEEDID => FieldType::INTPOSITIVE,
        F::VALUE       => FieldType::FLOAT,
        F::EXTRA       => FieldType::STRING,
    ];
}
