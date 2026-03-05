<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterAbility extends Entity
{
    public const FIELDS = [
        F::ID,
        F::TYPEID,
        F::MONSTERID,
        F::POWERID,
        F::NAME,
        F::DESCRIPTION,
        F::RANK,
    ];

    public const FIELD_TYPES = [
        F::TYPEID      => FieldType::STRING,
        F::MONSTERID   => FieldType::INTPOSITIVE,
        F::POWERID     => FieldType::INTPOSITIVE,
        F::NAME        => FieldType::STRING,
        F::DESCRIPTION => FieldType::STRING,
        F::RANK        => FieldType::INTPOSITIVE,
    ];

    public function stringify(): string
    {
        return sprintf(
            "%s - %s : %s",
            $this->typeId,
            $this->name,
            $this->getExcerpt()
        );
    }

    public function getExcerpt(int $max = 80): string
    {
        return mb_strlen($this->description) > $max
            ? mb_substr($this->description, 0, $max) . '...'
            : $this->description;
    }
}
