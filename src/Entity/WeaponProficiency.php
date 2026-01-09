<?php
namespace src\Entity;

use src\Constant\Field;

class WeaponProficiency extends Entity
{
    public const TABLE = 'rpgWeaponProficiency';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];

    public const FIELD_TYPES = [
        Field::NAME => 'string',
    ];
    
    protected string $name = '';

    public function stringify(): string
    {
        return $this->getName();
    }
}
