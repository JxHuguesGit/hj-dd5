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
    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::DESCRIPTION => 'string',
    ];
    
    protected string $name        = '';
    protected string $description = '';

    public function stringify(): string
    {
        return sprintf(
            "%s - Description : %s",
            $this->getName(),
            $this->getExcerpt()
        );
    }
    
    public function getExcerpt(int $max = 80): string
    {
        return mb_strlen($this->description) > $max
            ? mb_substr($this->description, 0, $max) . '...'
            : $this->description;
    }
}
