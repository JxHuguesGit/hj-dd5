<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class FeatPreRequis extends Entity
{
    public const FIELDS = [
        F::ID,
        F::FEATID,
        F::PREREQUISID,
    ];

    public const FIELD_TYPES = [
        F::FEATID    => FieldType::INTPOSITIVE,
        F::PREREQUISID => FieldType::INTPOSITIVE,
    ];
}
