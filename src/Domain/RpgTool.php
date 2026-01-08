<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;

/**
 * @property int $parentId
 */
final class RpgTool extends RpgItem
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

}
