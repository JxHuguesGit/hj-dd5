<?php
namespace src\Entity;

use src\Constant\Field;

class RpgAbility extends Entity
{
    public const TABLE = 'rpgAbility';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];
    public const FIELD_TYPES = [
        Field::NAME => 'string',
    ];
    
    protected string $name = '';

}
