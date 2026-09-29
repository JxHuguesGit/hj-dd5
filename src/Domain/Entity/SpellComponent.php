<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class SpellComponent extends Entity
{
    public const FIELDS = [
        F::ID,
        F::DESCRIPTION,
    ];
    public const FIELD_TYPES = [
        F::DESCRIPTION => FieldType::STRING,
    ];
}
