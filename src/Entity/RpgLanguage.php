<?php
namespace src\Entity;

use src\Constant\Field;

class RpgLanguage extends Entity
{
    public const TABLE = 'rpgLanguage';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];

    protected string $name;
}
