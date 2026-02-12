<?php
namespace src\Domain\Monster;

use src\Constant\Field;
use src\Domain\Entity\Alignement;

final class MonsterAlignment
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getId(): int
    {
        return $this->monster->getField(Field::ALGNID);
    }

    public function getEntity(): ?Alignement
    {
        $id = $this->getId();
        if ($id === 0) {
            return null;
        }
        return new Alignement([Field::ID => $id]);
    }

    public function getName(): string
    {
        return $this->getEntity()?->stringify() ?? 'Alignement inconnu';
    }
}
