<?php
namespace src\Entity;

use src\Constant\Field;

class RpgOriginSkill extends Entity
{
    public const TABLE = 'rpgOriginSkill';
    public const FIELDS = [
        Field::ID,
        Field::ORIGINID,
        Field::SKILLID,
    ];

    protected int $originId;
    protected int $skillId;
}
