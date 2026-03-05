<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

/**
 * @property string $name
 * @property string $description
 * @property int $parentId
 */
final class Power extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
        F::DESCRIPTION,
        F::PARENTID,
    ];
    public const FIELD_TYPES = [
        F::NAME => FieldType::STRING,
        F::DESCRIPTION => FieldType::STRING,
        F::PARENTID => FieldType::INTPOSITIVE,
    ];

    public function stringify(): string
    {
        return $this->name;
    }
}
