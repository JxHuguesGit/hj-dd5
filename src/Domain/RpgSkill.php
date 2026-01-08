<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;

/**
 * @property string $name
 * @property string $slug
 */
final class RpgSkill extends Entity
{
    public const FIELDS = [
        Field::NAME,
        Field::SLUG,
    ];
    public const FIELD_TYPES = [
        Field::NAME => FieldType::STRING,
        Field::SLUG => FieldType::STRING,
    ];
    
    public function stringify(): string
    {
        return $this->name;
    }
}
