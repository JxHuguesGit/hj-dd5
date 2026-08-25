<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

final class Map extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
        F::IMAGE,
        F::MAPCOLUMNS,
        F::MAPROWS,
        F::CELLSIZE,
        F::ACTIVE,
        F::LOCKED,
        F::VISIONRANGE,
    ];

    public const FIELD_TYPES = [
        F::NAME        => FieldType::STRING,
        F::IMAGE       => FieldType::STRING,
        F::MAPCOLUMNS  => FieldType::INTPOSITIVE,
        F::MAPROWS     => FieldType::INTPOSITIVE,
        F::CELLSIZE    => FieldType::INTPOSITIVE,
        F::ACTIVE      => FieldType::INTPOSITIVE,
        F::LOCKED      => FieldType::INTPOSITIVE,
        F::VISIONRANGE => FieldType::INTPOSITIVE,
    ];

    public const EDITABLE_FIELDS = [
        F::NAME,
        F::IMAGE,
        F::MAPCOLUMNS,
        F::MAPROWS,
        F::CELLSIZE,
        F::ACTIVE,
        F::LOCKED,
        F::VISIONRANGE,
    ];
}
