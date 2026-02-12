<?php

namespace src\Domain\Monster;

use src\Constant\Field;
use src\Utils\Utils;

final class MonsterIdentity
{
    public function __construct(
        private Monster $monster)
    {}

    public function getId(): int
    {
        return $this->monster->getField(Field::ID);
    }

    public function getName(): string
    {
        return $this->monster->getField(Field::NAME);
    }

    public function getFrenchName(): string
    {
        return $this->monster->getField(Field::FRNAME);
    }

    public function getTag(): ?string
    {
        return $this->monster->getField(Field::UKTAG);
    }

    public function getFrenchTag(): ?string
    {
        return $this->monster->getField(Field::FRTAG);
    }

    public function getReferenceId(): int
    {
        return $this->monster->getField(Field::REFID);
    }

    public function isComplete(): bool
    {
        return $this->monster->getField(Field::INCOMPLET) == 0;
    }

    public function getSlug(): string
    {
        $slug = $this->monster->getField(Field::SLUG) ?? '';

        if ($slug !== '') {
            return $slug;
        }

        return Utils::slugify($this->getName());
    }
}
