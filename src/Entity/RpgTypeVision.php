<?php
namespace src\Entity;

use src\Constant\Field;

class RpgTypeVision extends Entity
{
    public const TABLE = 'rpgTypeVision';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::UKTAG,
    ];

    protected string $name;
    protected string $ukTag;
}
