<?php
namespace src\Entity;

use src\Constant\Field;

class TypeDamage extends Entity
{
    public const TABLE = 'TypeDamage';
    public const FIELDS = [
        Field::ID,
        Field::CODE,
    ];

    protected string $code;
}
