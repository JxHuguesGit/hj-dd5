<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

final class MapToken extends Entity
{
    public const FIELDS = [
        F::ID,
        F::MAPID,
        F::MONSTERID,
        F::CHARACTERID,
        F::IMAGE,
        F::COLUMN,
        F::ROW,
        F::SIZE,
        F::NUMBER,
    ];

    public const FIELD_TYPES = [
        F::MAPID       => FieldType::INTPOSITIVE,
        F::MONSTERID   => FieldType::INTNULLABLE,
        F::CHARACTERID => FieldType::INTNULLABLE,
        F::IMAGE       => FieldType::STRING,
        F::COLUMN      => FieldType::INTPOSITIVE,
        F::ROW         => FieldType::INTPOSITIVE,
        F::SIZE        => FieldType::INTPOSITIVE,
        F::NUMBER      => FieldType::INTNULLABLE,
    ];

    public const EDITABLE_FIELDS = [
        F::COLUMN,
        F::ROW,
    ];
}
