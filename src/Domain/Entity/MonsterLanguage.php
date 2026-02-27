<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterLanguage extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::MONSTERID,
        Field::LANGUAGEID,
        Field::VALUE,
    ];

    public const FIELD_TYPES = [
        Field::MONSTERID  => FieldType::INTPOSITIVE,
        Field::LANGUAGEID => FieldType::INTPOSITIVE,
        Field::VALUE      => FieldType::INTPOSITIVE,
    ];
}
