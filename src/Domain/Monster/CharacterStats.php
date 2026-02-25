<?php
namespace src\Domain\Monster;

use src\Constant\Field;

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
        return $this->monster->getField(Field::STRSCORE);
    }

    public function getDexterity(): int
    {
        return $this->monster->getField(Field::DEXSCORE);
    }

    public function getConstitution(): int
    {
        return $this->monster->getField(Field::CONSCORE);
    }

    public function getIntelligence(): int
    {
        return $this->monster->getField(Field::INTSCORE);
    }

    public function getWisdom(): int
    {
        return $this->monster->getField(Field::WISSCORE);
    }

    public function getCharisma(): int
    {
        return $this->monster->getField(Field::CHASCORE);
    }

    public function getProficiencyBonus(): int
    {
        return $this->monster->getField(Field::PROFBONUS);
    }

    public function getPassivePerception(): int
    {
        return $this->monster->getField(Field::PERCPASSIVE);
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
