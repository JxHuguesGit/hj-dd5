<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Utils;

/**
 * @property string $name
 * @property string $slug
 * @property ?int $preRequisId
 */
final class FeatType extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
        F::SLUG,
        F::PREREQUISID,
    ];
    public const FIELD_TYPES = [
        F::NAME        => FieldType::STRING,
        F::SLUG        => FieldType::STRING,
        F::PREREQUISID => FieldType::INTNULLABLE,
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
