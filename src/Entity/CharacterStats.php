<?php
namespace src\Entity;

use src\Constant\Field;

class CharacterStats extends SubEntity
{
    protected array $map = [
        Field::SCOREHP       => Field::SCOREHP,
        'str'           => Field::STRSCORE,
        'dex'           => Field::DEXSCORE,
        'con'           => Field::CONSCORE,
        'int'           => Field::INTSCORE,
        'wis'           => Field::WISSCORE,
        'cha'           => Field::CHASCORE,
        Field::PROFBONUS     => Field::PROFBONUS,
        Field::PERCPASSIVE   => Field::PERCPASSIVE,
    ];
}
