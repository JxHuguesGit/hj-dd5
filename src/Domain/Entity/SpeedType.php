<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
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
        F::ID,
        F::NAME,
        F::UKTAG,
        F::FRTAG,
    ];
    public const FIELD_TYPES = [
        F::NAME  => FieldType::STRING,
        F::UKTAG => FieldType::STRING,
        F::FRTAG => FieldType::STRING,
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
