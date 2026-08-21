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
        F::TOKENID,
        F::COLUMN,
        F::ROW,
        F::SIZE,
        F::NUMBER,
        F::ACTIVE,
        F::ENABLEPJMOVE,
    ];

    public const RELATION_FIELDS = [
        F::NAME,
        F::IMAGE,
    ];

    public const FIELD_TYPES = [
        F::MAPID       => FieldType::INTPOSITIVE,
        F::TOKENID     => FieldType::INTPOSITIVE,
        F::COLUMN      => FieldType::INTPOSITIVE,
        F::ROW         => FieldType::INTPOSITIVE,
        F::SIZE        => FieldType::INTPOSITIVE,
        F::NUMBER      => FieldType::INTNULLABLE,
        F::ACTIVE      => FieldType::INTPOSITIVE,
        F::ENABLEPJMOVE => FieldType::INTPOSITIVE,

        F::NAME        => FieldType::STRING,
        F::IMAGE       => FieldType::STRING,
    ];

    public const EDITABLE_FIELDS = [
        F::COLUMN,
        F::ROW,
        F::ENABLEPJMOVE,
    ];
}
