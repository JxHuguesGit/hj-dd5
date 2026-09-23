<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class Classe extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
        F::SKILLS,
        F::CODE,
    ];

    public const FIELD_TYPES = [
        F::NAME   => FieldType::STRING,
        F::SKILLS => FieldType::INTPOSITIVE,
        F::CODE   => FieldType::STRING,
    ];

    public function stringify(): string
    {
        return $this->name ?? '-';
    }
}
