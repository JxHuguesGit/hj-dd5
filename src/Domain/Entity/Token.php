<?php
namespace src\Domain\Entity;


use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

final class Token extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
        F::IMAGE,
        F::SIZE,
        F::TYPE,
        F::ENTITYID,
        F::ACTIVE,
    ];

    public const FIELD_TYPES = [
        F::NAME        => FieldType::STRING,
        F::IMAGE       => FieldType::STRING,
        F::SIZE        => FieldType::INTPOSITIVE,
        F::TYPE        => FieldType::STRING,
        F::ENTITYID    => FieldType::INTPOSITIVE,
        F::ACTIVE      => FieldType::INTPOSITIVE,
    ];

    public const EDITABLE_FIELDS = [
        F::NAME,
        F::IMAGE,
        F::SIZE,
        F::TYPE,
        F::ENTITYID,
        F::ACTIVE,
    ];
}
