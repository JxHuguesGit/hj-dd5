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

    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::UKTAG => 'string',
    ];
    
    protected string $name = '';
    protected string $ukTag = '';

    public function stringify(): string
    {
        return $this->getName();
    }
}
