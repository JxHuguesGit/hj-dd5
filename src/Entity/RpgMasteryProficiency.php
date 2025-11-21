<?php
namespace src\Entity;

use src\Constant\Field;

class RpgMasteryProficiency extends Entity
{
    public const TABLE = 'rpgMasteryProficiency';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];

    protected string $name;
}
