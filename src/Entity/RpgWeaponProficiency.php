<?php
namespace src\Entity;

use src\Constant\Field;

class RpgWeaponProficiency extends Entity
{
    public const TABLE = 'rpgWeaponProficiency';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];

    protected string $name;
}
