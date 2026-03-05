<?php
namespace src\Domain\Entity;

use src\Constant\Field as F;
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
        F::TYPEDMGID,
        F::MSTPROFID,
        F::WPNCATID,
        F::WPNRANGEID,
        F::DMGDIEID,

        F::CATEGORYSLUG,
        F::CATEGORYNAME,

        F::MASTERYNAME,
        F::MASTERYPOSTID,

        F::DICECOUNT,
        F::DICEFACES,

        F::TYPDMGNAME,

        F::RANGESLUG,
        F::RANGENAME,
    ];

    public const SPECIFIC_FIELD_TYPES = [
        F::TYPEDMGID => FieldType::INT,
        F::MSTPROFID => FieldType::INT,
        F::WPNCATID => FieldType::INT,
        F::WPNRANGEID => FieldType::INT,
        F::DMGDIEID => FieldType::INT,

        F::CATEGORYSLUG => FieldType::STRING,
        F::CATEGORYNAME => FieldType::STRING,

        F::MASTERYNAME => FieldType::STRING,
        F::MASTERYPOSTID => FieldType::INT,

        F::DICECOUNT => FieldType::INT,
        F::DICEFACES => FieldType::INT,

        F::TYPDMGNAME => FieldType::STRING,

        F::RANGESLUG => FieldType::STRING,
        F::RANGENAME => FieldType::STRING,
    ];

    public const FIELDS = [
        ...self::COMMON_FIELDS,
        ...self::SPECIFIC_FIELDS,
        /*
        F::ID,
        F::NAME,
        F::WEIGHT,
        F::GOLDPRICE,
        F::TYPEDMGID,
        F::MSTPROFID,
        F::WPNCATID,
        F::WPNRANGEID,
        F::DMGDIEID,
        */
    ];
    public const FIELD_TYPES = [
        ...self::COMMON_FIELD_TYPES,
        ...self::SPECIFIC_FIELD_TYPES,
        /*
        F::NAME =>       FieldType::STRING,
        F::WEIGHT =>     FieldType::FLOAT,
        F::GOLDPRICE =>  FieldType::FLOAT,
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
