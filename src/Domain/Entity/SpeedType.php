<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Utils;

/**
 * @property string $name
 * @property string $ukTag
 * @property string $frTag
 */
final class SpeedType extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::UKTAG,
        Field::FRTAG,
    ];
    public const FIELD_TYPES = [
        Field::NAME  => FieldType::STRING,
        Field::UKTAG => FieldType::STRING,
        Field::FRTAG => FieldType::STRING,
    ];

    public function stringify(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->frTag !== ''
            ? $this->frTag
            : Utils::slugify($this->name);
    }

}
