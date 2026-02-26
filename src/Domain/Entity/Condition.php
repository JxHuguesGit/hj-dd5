<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

/**
 * @property string $name
 * @property string $description
 */
final class Condition extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::DESCRIPTION,
    ];
    public const FIELD_TYPES = [
        Field::NAME        => FieldType::STRING,
        Field::DESCRIPTION => FieldType::STRING,
    ];

    public function stringify(): string
    {
        return $this->name;
    }
}
