<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

final class Initiative extends Entity
{
    public const FIELDS = [
        F::ID,
        F::MAPID,
        F::MAPTOKENID,
        F::INITIATIVE,
        F::ACTIVE,
    ];

    public const FIELD_TYPES = [
        F::MAPID      => FieldType::INTPOSITIVE,
        F::MAPTOKENID => FieldType::INTPOSITIVE,
        F::INITIATIVE => FieldType::FLOAT,
        F::ACTIVE     => FieldType::INTPOSITIVE,
    ];

    public const EDITABLE_FIELDS = [
        F::INITIATIVE,
        F::ACTIVE,
    ];
}
