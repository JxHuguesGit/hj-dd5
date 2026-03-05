<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

/**
 * @property int $characterId
 * @property int $skillId
 * @property int $expertise
 */
final class CharacterSkill extends Entity
{
    public const FIELDS = [
        F::ID,
        F::CHARACTERID,
        F::SKILLID,
        F::EXPERTISE,
    ];
    public const FIELD_TYPES = [
        F::CHARACTERID => FieldType::INTPOSITIVE,
        F::SKILLID     => FieldType::INTPOSITIVE,
        F::EXPERTISE   => FieldType::INTPOSITIVE,
    ];

    /**
     * Retourne une représentation texte de l'historique
     */
    public function stringify(): string
    {
        return sprintf(
            "CharacterId : %d - SkillId : %d - Expertise : %d",
            $this->characterId,
            $this->skillId,
            $this->expertise
        );
    }

}
