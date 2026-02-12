<?php

namespace src\Domain\Monster;

use src\Constant\Field;

final class MonsterCombatStats
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getArmorClass(): int
    {
        return $this->monster->getField(Field::SCORECA);
    }

    public function getHitPoints(): int
    {
        return $this->monster->getField(Field::SCOREHP);
    }

    public function getSpeed(): string
    {
        return $this->monster->getField(Field::SPEED);
    }

    public function getInitiative(): int
    {
        return $this->monster->getField(Field::INITIATIVE);
    }

    public function getChallengeRating(): float
    {
        return $this->monster->getField(Field::SCORECR);
    }

    public function isLegendary(): bool
    {
        return (bool) $this->monster->getField(Field::LEGENDARY);
    }
}
