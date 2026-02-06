<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Utils\Utils;

/**
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property float $weight
 * @property float $goldPrice
 * @property string $type
 */
class Item extends Entity
{
    public const FIELDS = [
        Field::NAME,
        Field::SLUG,
        Field::DESCRIPTION,
        Field::WEIGHT,
        Field::GOLDPRICE,
        Field::TYPE,
    ];

    public const COMMON_FIELDS = [
        Field::NAME,
        Field::SLUG,
        Field::DESCRIPTION,
        Field::WEIGHT,
        Field::GOLDPRICE,
        Field::TYPE,
    ];

    public const FIELD_TYPES = [
        Field::NAME =>        FieldType::STRING,
        Field::SLUG =>        FieldType::STRING,
        Field::DESCRIPTION => FieldType::STRING,
        Field::WEIGHT =>      FieldType::FLOAT,
        Field::GOLDPRICE =>   FieldType::FLOAT,
        Field::TYPE =>        FieldType::STRING,
    ];

    public const COMMON_FIELD_TYPES = [
        Field::NAME =>        FieldType::STRING,
        Field::SLUG =>        FieldType::STRING,
        Field::DESCRIPTION => FieldType::STRING,
        Field::WEIGHT =>      FieldType::FLOAT,
        Field::GOLDPRICE =>   FieldType::FLOAT,
        Field::TYPE =>        FieldType::STRING,
    ];

    public const EDITABLE_FIELDS = [
        Field::DESCRIPTION,
        Field::WEIGHT,
        Field::GOLDPRICE,
        Field::TYPE,
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

    public function getSlug(): string
    {
        return $this->slug !== ''
            ? $this->slug
            : Utils::slugify($this->name);
    }
}
