<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;
use src\Utils\Utils;

/**
 * @property string $name
 * @property string $slug
 * @property int $abilityid
 */
final class Skill extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::SLUG,
        Field::ABILITYID,
        Field::DESCRIPTION,
    ];
    public const FIELD_TYPES = [
        Field::NAME => FieldType::STRING,
        Field::SLUG => FieldType::STRING,
        Field::ABILITYID => FieldType::INTPOSITIVE,
        Field::DESCRIPTION => FieldType::STRING,
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
