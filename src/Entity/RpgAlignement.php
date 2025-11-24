<?php
namespace src\Entity;

use src\Constant\Field;

class RpgAlignement extends Entity
{
    public const TABLE = 'rpgAlignement';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
    ];
    public const FIELD_TYPES = [
        Field::NAME => 'string',
    ];
    
    protected string $name = '';

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
        return '['.$this->getId().'] '.$this->getStrAlignement();
    }
}
