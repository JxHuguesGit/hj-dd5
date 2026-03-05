<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterSkill extends Entity
{
    public const FIELDS = [
        F::ID,
        F::MONSTERID,
        F::SKILLID,
        F::VALUE,
    ];

    public const FIELD_TYPES = [
        F::MONSTERID => FieldType::INTPOSITIVE,
        F::SKILLID   => FieldType::INTPOSITIVE,
        F::VALUE     => FieldType::FLOAT,
    ];
}
