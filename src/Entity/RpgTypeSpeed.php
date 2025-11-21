<?php
namespace src\Entity;

use src\Constant\Field;

class RpgTypeSpeed extends Entity
{
    public const TABLE = 'rpgTypeSpeed';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::UKTAG,
        Field::FRTAG,
    ];

    protected string $name;
    protected string $ukTag;
    protected string $frTag;
}
