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
    
    public const FIELD_TYPES = [
        Field::NAME => 'string',
    ];
    
    protected string $name = '';

    public function stringify(): string
    {
        return $this->getName();
    }
}
