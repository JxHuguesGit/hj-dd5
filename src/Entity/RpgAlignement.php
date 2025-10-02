<?php
namespace src\Entity;

class RpgAlignement extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name
    ) {

    }

    public function getStrAlignement(): string
    {
        return str_replace(
            ['Neutral', 'Evil', 'Lawful', 'Chaotic', 'Good', 'Unaligned', 'Any Alignment'],
            ['Neutre', 'Mauvais', 'Loyal', 'Chaotique', 'Bon', 'Non aligné', 'Tout alignement'],
            $this->name
        );
    }
}
