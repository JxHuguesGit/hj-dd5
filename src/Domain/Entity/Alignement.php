<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

class Alignement extends Entity
{
    public const FIELDS = [
        F::ID,
        F::NAME,
    ];
    public const FIELD_TYPES = [
        F::NAME => FieldType::STRING,
    ];

    protected const ALIGNEMENT_MAP = [
        'Neutral'       => 'Neutre',
        'Evil'          => 'Mauvais',
        'Lawful'        => 'Loyal',
        'Chaotic'       => 'Chaotique',
        'Good'          => 'Bon',
        'Unaligned'     => 'Non aligné',
        'Any Alignment' => 'Tout alignement',
    ];

    public function getStrAlignement(): string
    {
        return self::ALIGNEMENT_MAP[$this->name] ?? $this->name;
    }

    public function stringify(): string
    {
        return $this->getStrAlignement();
    }
}
