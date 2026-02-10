<?php
namespace src\Domain\Entity;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Domain\Entity\Item;
use src\Utils\Utils;

/**
 * @property string $name
 * @property string $slug
 * @property float $weight
 * @property float $goldPrice
 * @property int $typeDamageId
 * @property int $masteryProficiencyId
 * @property int $weaponCategoryId
 * @property int $weaponRangeId
 * @property int $damageDieId
 * @property string $categorySlug
 * @property string $categoryName
 * @property string $masteryName
 * @property int $masteryPostId
 * @property int $diceCount
 * @property int $diceFaces
 * @property string $typeDamageName
 * @property string $rangeSlug
 * @property string $rangeName
 */
final class Weapon extends Item
{
    public const SPECIFIC_FIELDS = [
        Field::TYPEDMGID,
        Field::MSTPROFID,
        Field::WPNCATID,
        Field::WPNRANGEID,
        Field::DMGDIEID,

        Field::CATEGORYSLUG,
        Field::CATEGORYNAME,

        Field::MASTERYNAME,
        Field::MASTERYPOSTID,

        Field::DICECOUNT,
        Field::DICEFACES,

        Field::TYPDMGNAME,

        Field::RANGESLUG,
        Field::RANGENAME,
    ];

    public const SPECIFIC_FIELD_TYPES = [
        Field::TYPEDMGID => FieldType::INT,
        Field::MSTPROFID => FieldType::INT,
        Field::WPNCATID => FieldType::INT,
        Field::WPNRANGEID => FieldType::INT,
        Field::DMGDIEID => FieldType::INT,

        Field::CATEGORYSLUG => FieldType::STRING,
        Field::CATEGORYNAME => FieldType::STRING,

        Field::MASTERYNAME => FieldType::STRING,
        Field::MASTERYPOSTID => FieldType::INT,

        Field::DICECOUNT => FieldType::INT,
        Field::DICEFACES => FieldType::INT,

        Field::TYPDMGNAME => FieldType::STRING,

        Field::RANGESLUG => FieldType::STRING,
        Field::RANGENAME => FieldType::STRING,
    ];

    public const FIELDS = [
        ...self::COMMON_FIELDS,
        ...self::SPECIFIC_FIELDS,
        /*
        Field::ID,
        Field::NAME,
        Field::WEIGHT,
        Field::GOLDPRICE,
        Field::TYPEDMGID,
        Field::MSTPROFID,
        Field::WPNCATID,
        Field::WPNRANGEID,
        Field::DMGDIEID,
        */
    ];
    public const FIELD_TYPES = [
        ...self::COMMON_FIELD_TYPES,
        ...self::SPECIFIC_FIELD_TYPES,
        /*
        Field::NAME =>       FieldType::STRING,
        Field::WEIGHT =>     FieldType::FLOAT,
        Field::GOLDPRICE =>  FieldType::FLOAT,
        */
    ];

    /**
     * Retourne une représentation texte de l'armure
     */
    public function stringify(): string
    {
        return sprintf(
            "%s - Poids: %s - Prix: %s",
            $this->name,
            $this->weight,
            $this->goldPrice
        );
    }

    public function isMartial(): bool
    {
        return $this->categorySlug === 'martial';
    }

    public function isSimple(): bool
    {
        return $this->categorySlug === 'simple';
    }

    public function isMelee(): bool
    {
        return $this->rangeSlug === 'melee';
    }

    public function isRanged(): bool
    {
        return $this->rangeSlug === 'ranged';
    }

    public function getSlug(): string
    {
        return $this->slug !== ''
            ? $this->slug
            : Utils::slugify($this->name);
    }
}
