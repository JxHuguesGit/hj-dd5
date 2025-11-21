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

    protected string $name;

    public function getStrAlignement(): string
    {
        return str_replace(
            ['Neutral', 'Evil', 'Lawful', 'Chaotic', 'Good', 'Unaligned', 'Any Alignment'],
            ['Neutre', 'Mauvais', 'Loyal', 'Chaotique', 'Bon', 'Non aligné', 'Tout alignement'],
            $this->name
        );
    }
}
