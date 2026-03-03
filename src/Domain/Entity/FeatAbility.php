<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

class FeatAbility extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::FEATID,
        Field::ABILITYID,
    ];

    public const FIELD_TYPES = [
        Field::FEATID    => FieldType::INTPOSITIVE,
        Field::ABILITYID => FieldType::INTPOSITIVE,
    ];
}
