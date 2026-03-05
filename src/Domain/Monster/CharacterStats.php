<?php
namespace src\Domain\Monster;

use src\Constant\Field as F;

final class CharacterStats
{
    public function __construct(
        private Monster $monster
    ) {}

    public function getScore(string $carac): int
    {
        return match ($carac) {
            'str'   => $this->getStrength(),
            'dex'   => $this->getDexterity(),
            'con'   => $this->getConstitution(),
            'int'   => $this->getIntelligence(),
            'wis'   => $this->getWisdom(),
            'cha'   => $this->getCharisma(),
            default => 0,
        };
    }

    public function getStrength(): int
    {
        return $this->monster->getField(F::STRSCORE);
    }

    public function getDexterity(): int
    {
        return $this->monster->getField(F::DEXSCORE);
    }

    public function getConstitution(): int
    {
        return $this->monster->getField(F::CONSCORE);
    }

    public function getIntelligence(): int
    {
        return $this->monster->getField(F::INTSCORE);
    }

    public function getWisdom(): int
    {
        return $this->monster->getField(F::WISSCORE);
    }

    public function getCharisma(): int
    {
        return $this->monster->getField(F::CHASCORE);
    }

    public function getProficiencyBonus(): int
    {
        return $this->monster->getField(F::PROFBONUS);
    }

    public function getPassivePerception(): int
    {
        return $this->monster->getField(F::PERCPASSIVE);
    }

    /* =========================
       Méthodes métier utiles
       ========================= */

    public function getModifier(int $score): int
    {
        return intdiv($score - 10, 2);
    }

    public function getStrengthModifier(): int
    {
        return $this->getModifier($this->getStrength());
    }

    public function getDexterityModifier(): int
    {
        return $this->getModifier($this->getDexterity());
    }

    public function getConstitutionModifier(): int
    {
        return $this->getModifier($this->getConstitution());
    }

    public function getIntelligenceModifier(): int
    {
        return $this->getModifier($this->getIntelligence());
    }

    public function getWisdomModifier(): int
    {
        return $this->getModifier($this->getWisdom());
    }

    public function getCharismaModifier(): int
    {
        return $this->getModifier($this->getCharisma());
    }
}
