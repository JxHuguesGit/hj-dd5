<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Utils;

/**
 * @property int $abilityid
 * @property int $wpPostId
 * @property ?int $parentId
 * @property ?string $name
 * @property ?string $slug
 * @property ?string $description
 */
final class Skill extends Entity
{
    public const FIELDS = [
        F::ID,
        F::ABILITYID,
        F::WPPOSTID,
        F::PARENTID,
    ];

    public const RELATION_FIELDS = [
        F::NAME,
        F::SLUG,
        F::DESCRIPTION,
    ];

    public const FIELD_TYPES = [
        F::ABILITYID   => FieldType::INTPOSITIVE,
        F::WPPOSTID    => FieldType::INTNULLABLE,
        F::PARENTID    => FieldType::INTNULLABLE,

        F::NAME        => FieldType::STRINGNULLABLE,
        F::SLUG        => FieldType::STRINGNULLABLE,
        F::DESCRIPTION => FieldType::STRINGNULLABLE,
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
