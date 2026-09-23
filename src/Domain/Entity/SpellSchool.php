<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class SpellSchool extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
        F::CODE,
    ];
    public const FIELD_TYPES = [
        F::NAME => FieldType::STRING,
        F::CODE => FieldType::STRING,
    ];

    public function stringify(): string
    {
        return $this->name ?? '-';
    }
}
