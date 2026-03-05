<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

/**
 * @property int $originId
 * @property int $abilityId
 */
final class OriginAbility extends Entity
{
    public const FIELDS = [
        F::ID,
        F::ORIGINID,
        F::ABILITYID,
    ];
    public const FIELD_TYPES = [
        F::ORIGINID =>  FieldType::INTPOSITIVE,
        F::ABILITYID => FieldType::INTPOSITIVE,
    ];

    /**
     * Retourne une représentation texte de l'historique
     */
    public function stringify(): string
    {
        return sprintf(
            "OriginId : %s - AbilityId : %s",
            $this->originId,
            $this->abilityId,
        );
    }

}
