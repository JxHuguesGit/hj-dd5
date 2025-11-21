<?php
namespace src\Entity;

use src\Constant\Field;

class RpgTypeAmmunition extends Entity
{
    public const TABLE = 'rpgTypeAmmunition';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];

    protected string $name;

}
