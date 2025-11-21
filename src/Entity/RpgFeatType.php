<?php
namespace src\Entity;

use src\Constant\Field;

class RpgFeatType extends Entity
{
    public const TABLE = 'rpgFeatType';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];

    protected string $name;
}
