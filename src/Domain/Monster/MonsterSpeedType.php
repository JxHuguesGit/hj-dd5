<?php
namespace src\Domain\Monster;

use src\Constant\Field;
use src\Domain\Entity\MonsterSpeedType as EntityMonsterSpeedType;


final class MonsterSpeedType
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getEntity(): EntityMonsterSpeedType
    {
        return new EntityMonsterSpeedType();
    }
}
