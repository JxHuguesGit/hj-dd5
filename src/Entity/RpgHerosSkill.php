<?php
namespace src\Entity;

use src\Constant\Field;

class RpgHerosSkill extends Entity
{
    public const TABLE = 'rpgHerosSkill';
    public const FIELDS = [
        Field::ID,
        Field::HEROSID,
        Field::SKILLID,
        Field::EXPERTISE,
    ];

    protected int $herosId;
    protected int $skillId;
    protected int $expertise;
}
