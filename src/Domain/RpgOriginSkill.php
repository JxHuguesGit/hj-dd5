<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;

/**
 * @property int $originId
 * @property int $skillId
 */
final class RpgOriginSkill extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::ORIGINID,
        Field::SKILLID,
    ];
    public const FIELD_TYPES = [
        Field::ORIGINID =>  FieldType::INTPOSITIVE,
        Field::SKILLID => FieldType::INTPOSITIVE,
    ];

    /**
     * Retourne une représentation texte de l'historique
     */
    public function stringify(): string
    {
        return sprintf(
            "OriginId : %s - SkillId : %s",
            $this->originId,
            $this->skillId,
        );
    }

}
