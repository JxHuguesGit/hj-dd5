<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

/**
 * @property string $name
 */
final class DamageType extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
    ];
    public const FIELD_TYPES = [
        F::NAME => FieldType::STRING,
    ];

    public function stringify(): string
    {
        return $this->name;
    }
}
