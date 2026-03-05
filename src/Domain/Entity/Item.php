<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
use src\Constant\FieldType;
use src\Domain\Entity;
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
        F::NAME,
        F::SLUG,
        F::DESCRIPTION,
        F::WEIGHT,
        F::GOLDPRICE,
        F::TYPE,
    ];

    public const COMMON_FIELDS = [
        F::NAME,
        F::SLUG,
        F::DESCRIPTION,
        F::WEIGHT,
        F::GOLDPRICE,
        F::TYPE,
    ];

    public const FIELD_TYPES = [
        F::NAME =>        FieldType::STRING,
        F::SLUG =>        FieldType::STRING,
        F::DESCRIPTION => FieldType::STRING,
        F::WEIGHT =>      FieldType::FLOAT,
        F::GOLDPRICE =>   FieldType::FLOAT,
        F::TYPE =>        FieldType::STRING,
    ];

    public const COMMON_FIELD_TYPES = [
        F::NAME =>        FieldType::STRING,
        F::SLUG =>        FieldType::STRING,
        F::DESCRIPTION => FieldType::STRING,
        F::WEIGHT =>      FieldType::FLOAT,
        F::GOLDPRICE =>   FieldType::FLOAT,
        F::TYPE =>        FieldType::STRING,
    ];

    public const EDITABLE_FIELDS = [
        F::DESCRIPTION,
        F::WEIGHT,
        F::GOLDPRICE,
        F::TYPE,
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

    public function getExcerpt(int $maxWords = 15): string
    {
        return wp_trim_words($this->description, $maxWords, '…');
    }
}
