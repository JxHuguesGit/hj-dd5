<?php
namespace src\Domain\Monster;

use src\Domain\Entity\MonsterSpeedType as EntityMonsterSpeedType;


final class MonsterSpeedType
{
    public function __construct(
        private Monster $monster
    ) {
        // Supprimer une erreur Sonar le temps d'implémenter le sujet.
        unset($this->monster);
    }

    public function getEntity(): EntityMonsterSpeedType
    {
        return new EntityMonsterSpeedType();
    }
}
