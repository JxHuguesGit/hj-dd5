<?php

namespace src\Domain\Monster;

use src\Constant\Field as F;
use src\Utils\Utils;

final class MonsterIdentity
{
    public function __construct(
        private Monster $monster)
    {}

    public function getId(): int
    {
        return $this->monster->getField(F::ID);
    }

    public function getName(): string
    {
        return $this->monster->getField(F::NAME);
    }

    public function getFrenchName(): string
    {
        return $this->monster->getField(F::FRNAME);
    }

    public function getTag(): ?string
    {
        return $this->monster->getField(F::UKTAG);
    }

    public function getFrenchTag(): ?string
    {
        return $this->monster->getField(F::FRTAG);
    }

    public function getReferenceId(): int
    {
        return $this->monster->getField(F::REFID);
    }

    public function isComplete(): bool
    {
        return $this->monster->getField(F::INCOMPLET) == 0;
    }

    public function getSlug(): string
    {
        $slug = $this->monster->getField(F::SLUG) ?? '';

        if ($slug !== '') {
            return $slug;
        }

        return Utils::slugify($this->getName());
    }
}
