<?php
namespace src\Domain\Entity;

use src\Constant\Field;
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
        Field::ID,
        Field::SPECIESID,
        Field::POWERID,
        Field::RANK
    ];
    public const FIELD_TYPES = [
        Field::SPECIESID =>  FieldType::INTPOSITIVE,
        Field::POWERID => FieldType::INTPOSITIVE,
        Field::RANK => FieldType::INTPOSITIVE,
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
