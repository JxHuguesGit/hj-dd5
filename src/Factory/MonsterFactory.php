<?php
namespace src\Factory;

use src\Constant\Field;
use src\Entity\RpgMonster as EntityRpgMonster;
use src\Entity\CharacterStats;
use src\Entity\MonsterAbilities;
use src\Entity\MonsterDefenses;

class MonsterFactory
{
    public static function create(array $attributes): EntityRpgMonster
    {
        $monster = new EntityRpgMonster($attributes);

        // Hydratation post-construction
        $monster->setField('stats', new CharacterStats($attributes));
        $monster->setField('abilities', new MonsterAbilities($monster->getField(Field::ID)));
        $monster->setField('defenses', new MonsterDefenses($monster->getField(Field::ID)));

        return $monster;
    }
}
