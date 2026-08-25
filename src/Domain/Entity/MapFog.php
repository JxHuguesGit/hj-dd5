<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

final class MapFog extends Entity
{
    public const FIELDS = [
        F::ID,
        F::MAPID,
        F::MAPCOLUMN,
        F::MAPROW,
    ];

    public const FIELD_TYPES = [
        F::MAPID       => FieldType::INTPOSITIVE,
        F::MAPCOLUMN   => FieldType::INTPOSITIVE,
        F::MAPROW      => FieldType::INTPOSITIVE,
    ];
}
