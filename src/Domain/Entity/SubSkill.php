<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Utils;

/**
 * @property string $name
 * @property int $skillId
 * @property string $description
 */
final class SubSkill extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
        F::SLUG,
        F::SKILLID,
        F::DESCRIPTION,
    ];
    public const FIELD_TYPES = [
        F::NAME => FieldType::STRING,
        F::SLUG => FieldType::STRING,
        F::SKILLID => FieldType::INTPOSITIVE,
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
