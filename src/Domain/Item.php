<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;

/**
 * @property string $name
 * @property string $slug
 * @property float $weight
 * @property float $goldPrice
 */
abstract class Item extends Entity
{
    public const COMMON_FIELDS = [
        Field::NAME,
        Field::SLUG,
        Field::WEIGHT,
        Field::GOLDPRICE,
    ];

    public const COMMON_FIELD_TYPES = [
        Field::NAME =>       FieldType::STRING,
        Field::SLUG =>       FieldType::STRING,
        Field::WEIGHT =>     FieldType::FLOAT,
        Field::GOLDPRICE =>  FieldType::FLOAT,
    ];

    public function stringify(): string
    {
        return sprintf(
            "%s - Poids: %s - Prix: %s",
            $this->name,
            $this->weight,
            $this->goldPrice
        );
    }
}
