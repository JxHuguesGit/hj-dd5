<?php
namespace src\Entity;

class CharacterStats extends SubEntity
{
    protected array $map = [
        'hp'            => 'hp',
        'str'           => 'strScore',
        'dex'           => 'dexScore',
        'con'           => 'conScore',
        'int'           => 'intScore',
        'wis'           => 'wisScore',
        'cha'           => 'chaScore',
        'profBonus'     => 'profBonus',
        'percPassive'   => 'percPassive',
    ];
}
