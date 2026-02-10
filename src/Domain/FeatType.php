<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Utils\Utils;

/**
 * @property string $name
 * @property string $slug
 */
final class FeatType extends Entity
{
    public const FIELDS = [
        Field::ID,
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

    public function getSlug(): string
    {
        return $this->slug !== ''
            ? $this->slug
            : Utils::slugify($this->name);
    }
}
