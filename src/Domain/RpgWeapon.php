<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;

/**
 * @property string $name
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
 * @property int $diceCount
 * @property int $diceFaces
 * @property string $typeDamageName
 * @property string $rangeSlug
 * @property string $rangeName
 */
final class RpgWeapon extends Entity
{
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::WEIGHT,
        Field::GOLDPRICE,
        Field::TYPEDMGID,
        Field::MSTPROFID,
        Field::WPNCATID,
        Field::WPNRANGEID,
        Field::DMGDIEID,
        Field::CATEGORYSLUG,
        Field::CATEGORYNAME,
        Field::MASTERYNAME,
        Field::DICECOUNT,
        Field::DICEFACES,
        Field::TYPDMGNAME,
        Field::RANGESLUG,
        Field::RANGENAME,
    ];
    public const FIELD_TYPES = [
        Field::NAME =>       FieldType::STRING,
        Field::WEIGHT =>     FieldType::FLOAT,
        Field::GOLDPRICE =>  FieldType::FLOAT,
        Field::TYPEDMGID =>  FieldType::INT,
        Field::MSTPROFID =>  FieldType::INT,
        Field::WPNCATID =>   FieldType::INT,
        Field::WPNRANGEID => FieldType::INT,
        Field::DMGDIEID =>   FieldType::INT,
        Field::CATEGORYSLUG => FieldType::STRING,
        Field::CATEGORYNAME => FieldType::STRING,
        Field::MASTERYNAME => FieldType::STRING,
        Field::DICECOUNT =>   FieldType::INT,
        Field::DICEFACES =>   FieldType::INT,
        Field::TYPDMGNAME => FieldType::STRING,
        Field::RANGESLUG => FieldType::STRING,
        Field::RANGENAME => FieldType::STRING,
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

    public function getDamageDie(): string
    {
        // Cas spécial : dégâts fixes (ex : sarbacane = 1)
        if ($this->diceFaces <= 1) {
            return (string) $this->diceCount . ' ' . $this->typeDamageName;
        }

        return sprintf(
            '%dd%d %s',
            $this->diceCount,
            $this->diceFaces,
            $this->typeDamageName
        );
    }
/*
    public function getProperties(): array;
    public function hasProperty(string $slug): bool;
    public function getRange(): ?array;
    public function isVersatile(): bool;
    public function getVersatileDamage(): ?string;
    public function usesAmmunition(): bool;
    */
}
