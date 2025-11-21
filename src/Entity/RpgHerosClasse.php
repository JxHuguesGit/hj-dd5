<?php
namespace src\Entity;

use src\Constant\Field;

class RpgHerosClasse extends Entity
{
    public const TABLE = 'rpgHerosClasse';
    public const FIELDS = [
        Field::ID,
        Field::HEROSID,
        Field::CLASSEID,
        Field::NIVEAU,
    ];

    protected int $herosId;
    protected int $classeId;
    protected int $niveau;
}
