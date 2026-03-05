<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class FeatAbility extends Entity
{
    public const FIELDS = [
        F::ID,
        F::FEATID,
        F::ABILITYID,
    ];

    public const FIELD_TYPES = [
        F::FEATID    => FieldType::INTPOSITIVE,
        F::ABILITYID => FieldType::INTPOSITIVE,
    ];
}
