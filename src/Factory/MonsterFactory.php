<?php
namespace src\Factory;

use src\Entity\RpgMonster as EntityRpgMonster;

class MonsterFactory
{
    public static function create(array $attributes): EntityRpgMonster
    {
        return new EntityRpgMonster($attributes);
    }
}
