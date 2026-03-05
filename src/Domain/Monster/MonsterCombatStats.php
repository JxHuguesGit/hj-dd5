<?php

namespace src\Domain\Monster;

use src\Constant\Field as F;

final class MonsterCombatStats
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getArmorClass(): int
    {
        return $this->monster->getField(F::SCORECA);
    }

    public function getHitPoints(): int
    {
        return $this->monster->getField(F::SCOREHP);
    }

    public function getSpeed(): string
    {
        return $this->monster->getField(F::SPEED);
    }

    public function getInitiative(): int
    {
        return $this->monster->getField(F::INITIATIVE);
    }

    public function getChallengeRating(): float
    {
        return $this->monster->getField(F::SCORECR);
    }

    public function isLegendary(): bool
    {
        return (bool) $this->monster->getField(F::LEGENDARY);
    }
}
