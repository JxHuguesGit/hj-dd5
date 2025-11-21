<?php
namespace src\Entity;

use src\Constant\Field;

class RpgSubSkill extends Entity
{
    public const TABLE = 'rpgSubSkill';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::SKILLID,
        Field::DESCRIPTION,
    ];

    protected string $name;
    protected int $skillId;
    protected string $description;
}
