<?php
namespace src\Entity;

use src\Constant\Field;

class RpgReference extends Entity
{
    public const TABLE = 'rpgReference';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];

    protected string $name;
}
