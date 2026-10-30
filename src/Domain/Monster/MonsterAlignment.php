<?php

namespace src\Domain\Monster;

use src\Constant\Field as F;
use src\Domain\Entity\Alignement;

final class MonsterAlignment
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getId(): int
    {
        return $this->monster->getField(F::ALGNID) ?? 0;
    }

    public function getEntity(): ?Alignement
    {
        return new Alignement([
            F::ID => $this->monster->getField(F::ALGNID) ?? 0
        ]);
    }

    public function getName(): string
    {
        return $this->getEntity()?->stringify() ?? 'Alignement inconnu';
    }
}
