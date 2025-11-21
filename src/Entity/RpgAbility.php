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
    
    protected string $name = '';
}
