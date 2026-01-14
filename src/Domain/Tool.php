<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Utils\Utils;

/**
 * @property int $parentId
 */
final class Tool extends Item
{
    public const SPECIFIC_FIELDS = [
        Field::PARENTID,
    ];

    public const SPECIFIC_FIELD_TYPES = [
        Field::PARENTID => FieldType::INT,
    ];

    public const FIELDS = [
        ...self::COMMON_FIELDS,
        ...self::SPECIFIC_FIELDS,
    ];

    public const FIELD_TYPES = [
        ...self::COMMON_FIELD_TYPES,
        ...self::SPECIFIC_FIELD_TYPES,
    ];

    public function getSlug(): string
    {
        return $this->slug !== ''
            ? $this->slug
            : Utils::slugify($this->name);
    }

}
