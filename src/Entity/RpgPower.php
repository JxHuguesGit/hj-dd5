<?php
namespace src\Entity;

use src\Constant\Field;

class RpgPower extends Entity
{
    public const TABLE = 'rpgPower';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::DESCRIPTION,
    ];
    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::DESCRIPTION => 'string',
    ];
    protected string $name = '';
    protected string $description = '';

    public function stringify(): string
    {
        return $this->getName();
    }
}
