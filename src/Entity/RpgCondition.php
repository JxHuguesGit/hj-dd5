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
            "[%s] %s - Description : %s",
            $this->getId(),
            $this->getName(),
            $this->getDescription()
        );
    }
}
