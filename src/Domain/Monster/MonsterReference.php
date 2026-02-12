<?php
namespace src\Domain\Monster;

use src\Constant\Field;
use src\Domain\Entity\Reference;

final class MonsterReference
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getId(): int
    {
        return $this->monster->getField(Field::REFID) ?? 0;
    }

    public function getEntity(): ?Reference
    {
        return new Reference([
            Field::NAME => $this->monster->getField(Field::REFNAME) ?? ''
        ]);
    }

    public function getLabel(): string
    {
        return $this->getEntity()?->stringify() ?? 'Référence inconnue';
    }
}
