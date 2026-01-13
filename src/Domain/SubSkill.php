<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Utils\Utils;

/**
 * @property string $name
 * @property int $skillId
 * @property string $description
 */
final class SubSkill extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::SLUG,
        Field::SKILLID,
        Field::DESCRIPTION,
    ];
    public const FIELD_TYPES = [
        Field::NAME => FieldType::STRING,
        Field::SLUG => FieldType::STRING,
        Field::SKILLID => FieldType::INTPOSITIVE,
        Field::DESCRIPTION => FieldType::STRING,
    ];
    
    public function stringify(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->slug !== ''
            ? $this->slug
            : Utils::slugify($this->name);
    }
}
