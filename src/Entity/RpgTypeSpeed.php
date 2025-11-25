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

    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::UKTAG => 'string',
        Field::FRTAG => 'string',
    ];
    
    protected string $name = '';
    protected string $ukTag = '';
    protected string $frTag = '';

    public function stringify(): string
    {
        return $this->getName();
    }
}
