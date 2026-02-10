<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity;

/**
 * @property int $originId
 * @property int $abilityId
 */
final class OriginAbility extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::ORIGINID,
        Field::ABILITYID,
    ];
    public const FIELD_TYPES = [
        Field::ORIGINID =>  FieldType::INTPOSITIVE,
        Field::ABILITYID => FieldType::INTPOSITIVE,
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
