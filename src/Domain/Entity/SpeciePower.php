<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

/**
 * @property int $speciesId
 * @property int $powerId
 * @property int $rank
 */
final class SpeciePower extends Entity
{
    public const FIELDS = [
        F::ID,
        F::SPECIESID,
        F::POWERID,
        F::RANK
    ];
    public const FIELD_TYPES = [
        F::SPECIESID =>  FieldType::INTPOSITIVE,
        F::POWERID => FieldType::INTPOSITIVE,
        F::RANK => FieldType::INTPOSITIVE,
    ];

    /**
     * Retourne une représentation texte
     */
    public function stringify(): string
    {
        return sprintf(
            "SpeciesId : %s - PowerId : %s",
            $this->speciesId,
            $this->powerId,
        );
    }

}
