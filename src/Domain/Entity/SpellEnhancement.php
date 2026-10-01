<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class SpellEnhancement extends Entity
{
    public const FIELDS = [
        F::ID,
        F::TYPE,
        F::DESCRIPTION,
    ];
    public const FIELD_TYPES = [
        F::TYPE => FieldType::STRING,
        F::DESCRIPTION => FieldType::STRING,
    ];

    public function stringify(): string
    {
        return ($this->type == 'spell' ? 'Upcast' : 'Upgrade') . ' : ' . $this->description;
    }
}
