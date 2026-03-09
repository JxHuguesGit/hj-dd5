<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity\Item;
use src\Utils\Utils;

/**
 * @property int $parentId
 */
final class Tool extends Item
{
    public const TYPE_DIVERS = 0;
    public const TYPE_GAMES = 19;
    public const TYPE_MUSIC = 20;
    public const TYPE_TOOL = 158;

    public const SPECIFIC_FIELDS = [
        F::PARENTID,

        F::PARENTNAME,
    ];

    public const SPECIFIC_FIELD_TYPES = [
        F::PARENTID => FieldType::INT,

        F::PARENTNAME => FieldType::STRINGNULLABLE,
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
