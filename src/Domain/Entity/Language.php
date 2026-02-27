<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

/**
 * @property string $name
 */
final class Language extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];
    public const FIELD_TYPES = [
        Field::NAME => FieldType::STRING,
    ];

    public function stringify(): string
    {
        return $this->name;
    }
}
