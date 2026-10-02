<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class SpellClasse extends Entity
{
    public const FIELDS = [
        F::SPELLID,
        F::CLASSEID,
    ];

    public const FIELD_TYPES = [
        F::SPELLID  => FieldType::INTPOSITIVE,
        F::CLASSEID => FieldType::INTPOSITIVE,
    ];
}
