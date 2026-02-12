<?php

namespace src\Domain\Monster;

use src\Constant\Field;

final class MonsterClassification
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getTypeId(): int
    {
        return $this->monster->getField(Field::MSTTYPEID);
    }

    public function getSubTypeId(): ?int
    {
        return $this->monster->getField(Field::MSTSSTYPID);
    }

    public function getSize(): int
    {
        return $this->monster->getField(Field::MSTSIZE);
    }

    public function getSwarmSize(): ?int
    {
        return $this->monster->getField(Field::SWARMSIZE);
    }

    public function isSwarm(): bool
    {
        return $this->getSwarmSize() !== null;
    }

    public function getAlignmentId(): int
    {
        return $this->monster->getField(Field::ALGNID);
    }

    public function getHabitat(): ?string
    {
        return $this->monster->getField(Field::HABITAT);
    }
}
