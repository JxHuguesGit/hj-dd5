<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterLanguage extends Entity
{
    public const FIELDS = [
        F::ID,
        F::MONSTERID,
        F::LANGUAGEID,
        F::VALUE,
    ];

    public const FIELD_TYPES = [
        F::MONSTERID  => FieldType::INTPOSITIVE,
        F::LANGUAGEID => FieldType::INTPOSITIVE,
        F::VALUE      => FieldType::INTPOSITIVE,
    ];
}
