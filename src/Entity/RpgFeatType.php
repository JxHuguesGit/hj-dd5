<?php
namespace src\Entity;

use src\Constant\Field;

class RpgFeatType extends Entity
{
    public const TABLE = 'rpgFeatType';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::SLUG,
    ];
    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::SLUG => 'string',
    ];
    
    protected string $name = '';
    protected string $slug = '';
    
    public function stringify(): string
    {
        return $this->getName();
    }
}
