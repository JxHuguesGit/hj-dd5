<?php
namespace src\Entity;

use src\Constant\Field;

class RpgCondition extends Entity
{
    public const TABLE = 'rpgCondition';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::DESCRIPTION,
    ];

    protected string $name;
    protected string $description;
}
