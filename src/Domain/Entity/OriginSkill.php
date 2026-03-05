<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

/**
 * @property int $originId
 * @property int $skillId
 */
final class OriginSkill extends Entity
{
    public const FIELDS = [
        F::ID,
        F::ORIGINID,
        F::SKILLID,
    ];
    public const FIELD_TYPES = [
        F::ORIGINID =>  FieldType::INTPOSITIVE,
        F::SKILLID => FieldType::INTPOSITIVE,
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
