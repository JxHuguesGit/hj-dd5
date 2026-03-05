<?php
namespace src\Domain\Monster;

use src\Constant\Field as F;
use src\Domain\Entity\Reference;

final class MonsterReference
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getId(): int
    {
        return $this->monster->getField(F::REFID) ?? 0;
    }

    public function getEntity(): ?Reference
    {
        return new Reference([
            F::NAME => $this->monster->getField(F::REFNAME) ?? ''
        ]);
    }

    public function getLabel(): string
    {
        return $this->getEntity()?->stringify() ?? 'Référence inconnue';
    }
}
