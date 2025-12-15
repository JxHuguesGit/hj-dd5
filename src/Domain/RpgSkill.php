<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;

/**
 * @property string $name
 */
final class RpgSkill extends Entity
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
