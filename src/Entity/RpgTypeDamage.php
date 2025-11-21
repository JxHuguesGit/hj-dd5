<?php
namespace src\Entity;

use src\Constant\Field;

class RpgTypeDamage extends Entity
{
    public const TABLE = 'rpgTypeDamage';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];

    protected string $name;
}
