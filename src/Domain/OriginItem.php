<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;

/**
 * @property int $originId
 * @property int $itemId
 * @property int $quantity
 */
final class OriginItem extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::ORIGINID,
        Field::ITEMID,
        Field::QUANTITY,
    ];
    public const FIELD_TYPES = [
        Field::ORIGINID =>  FieldType::INTPOSITIVE,
        Field::ITEMID   => FieldType::INTPOSITIVE,
        Field::QUANTITY => FieldType::INTPOSITIVE,
    ];

    /**
     * Retourne une représentation texte
     */
    public function stringify(): string
    {
        return sprintf(
            "OriginId : %d - ItemId : %d - Quantité : %d",
            $this->originId,
            $this->abilityId,
            $this->quantity,
        );
    }

}
