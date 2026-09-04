<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

final class Combat extends Entity
{
    public const FIELDS = [
        F::ID,
        F::WPUSERID,
        F::MAPID,
        F::NAME,
        F::ROUND,
        F::CURRENTPARTICIPANTID,
        F::ACTIVE,
    ];

    public const FIELD_TYPES = [
        F::WPUSERID              => FieldType::INTPOSITIVE,
        F::MAPID                 => FieldType::INTNULLABLE,
        F::NAME                  => FieldType::STRING,
        F::ROUND                 => FieldType::INTPOSITIVE,
        F::CURRENTPARTICIPANTID  => FieldType::INTNULLABLE,
        F::ACTIVE                => FieldType::INTPOSITIVE,
    ];

    public const EDITABLE_FIELDS = [
        F::NAME,
        F::ROUND,
        F::CURRENTPARTICIPANTID,
        F::ACTIVE,
    ];
}
