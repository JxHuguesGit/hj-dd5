<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Utils;

/**
 * @property string $name
 * @property string $slug
 * @property int $abilityid
 * @property string $description
 */
final class Skill extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
        F::SLUG,
        F::ABILITYID,
        F::DESCRIPTION,
    ];
    public const FIELD_TYPES = [
        F::NAME => FieldType::STRING,
        F::SLUG => FieldType::STRING,
        F::ABILITYID => FieldType::INTPOSITIVE,
        F::DESCRIPTION => FieldType::STRING,
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
