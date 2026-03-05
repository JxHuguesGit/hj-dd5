<?php

namespace src\Domain\Monster;

use src\Constant\Field as F;

final class MonsterClassification
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getTypeId(): int
    {
        return $this->monster->getField(F::MSTTYPEID);
    }

    public function getSubTypeId(): ?int
    {
        return $this->monster->getField(F::MSTSSTYPID);
    }

    public function getSize(): int
    {
        return $this->monster->getField(F::MSTSIZE);
    }

    public function getSwarmSize(): ?int
    {
        return $this->monster->getField(F::SWARMSIZE);
    }

    public function isSwarm(): bool
    {
        return $this->getSwarmSize() !== null;
    }

    public function getAlignmentId(): int
    {
        return $this->monster->getField(F::ALGNID);
    }

    public function getHabitat(): ?string
    {
        return $this->monster->getField(F::HABITAT);
    }
}
