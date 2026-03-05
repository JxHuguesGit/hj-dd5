<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Utils;

/**
 * @property string $name
 * @property string $ukTag
 */
final class VisionType extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
        F::UKTAG,
    ];
    public const FIELD_TYPES = [
        F::NAME  => FieldType::STRING,
        F::UKTAG => FieldType::STRING,
    ];

    public function stringify(): string
    {
        return $this->name;
    }

    public function getSlug(): string
    {
        return $this->ukTag !== ''
            ? $this->ukTag
            : Utils::slugify($this->name);
    }

}
