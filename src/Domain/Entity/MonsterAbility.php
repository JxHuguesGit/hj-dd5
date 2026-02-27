<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

class MonsterAbility extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::TYPEID,
        Field::MONSTERID,
        Field::POWERID,
        Field::NAME,
        Field::DESCRIPTION,
        Field::RANK,
    ];

    public const FIELD_TYPES = [
        Field::TYPEID      => FieldType::STRING,
        Field::MONSTERID   => FieldType::INTPOSITIVE,
        Field::POWERID     => FieldType::INTPOSITIVE,
        Field::NAME        => FieldType::STRING,
        Field::DESCRIPTION => FieldType::STRING,
        Field::RANK        => FieldType::INTPOSITIVE,
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
