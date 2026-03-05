<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;

/**
 * @property int $originId
 * @property int $itemId
 * @property int $quantity
 */
final class OriginItem extends Entity
{
    public const FIELDS = [
        F::ID,
        F::ORIGINID,
        F::ITEMID,
        F::QUANTITY,
    ];
    public const FIELD_TYPES = [
        F::ORIGINID =>  FieldType::INTPOSITIVE,
        F::ITEMID   => FieldType::INTPOSITIVE,
        F::QUANTITY => FieldType::INTPOSITIVE,
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
