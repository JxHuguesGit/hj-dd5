<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;

/**
 * @property string $name
 * @property string $slug
 * @property int abilityid
 */
final class Skill extends Entity
{
    public const FIELDS = [
        Field::NAME,
        Field::SLUG,
        Field::ABILITYID,
    ];
    public const FIELD_TYPES = [
        Field::NAME => FieldType::STRING,
        Field::SLUG => FieldType::STRING,
        Field::ABILITYID => FieldType::INTPOSITIVE,
    ];
    
    public function stringify(): string
    {
        return $this->name;
    }
}
