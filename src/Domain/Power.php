<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;

/**
 * @property string $name
 * @property string $description
 * @property int $parentId
 */
final class Power extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::DESCRIPTION,
        Field::PARENTID,
    ];
    public const FIELD_TYPES = [
        Field::NAME => FieldType::STRING,
        Field::DESCRIPTION => FieldType::STRING,
        Field::PARENTID => FieldType::INTPOSITIVE,
    ];
    
    public function stringify(): string
    {
        return $this->name;
    }
}
