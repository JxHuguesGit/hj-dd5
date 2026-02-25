<?php
namespace src\Domain\Entity;

use src\Constant\Field;
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
        Field::ID,
        Field::CHARACTERID,
        Field::SKILLID,
        Field::EXPERTISE,
    ];
    public const FIELD_TYPES = [
        Field::CHARACTERID => FieldType::INTPOSITIVE,
        Field::SKILLID     => FieldType::INTPOSITIVE,
        Field::EXPERTISE   => FieldType::INTPOSITIVE,
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
