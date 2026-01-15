<?php
namespace src\Domain;

use src\Constant\Field;
use src\Constant\FieldType;
use src\Utils\Utils;

/**
 * @property string $name
 * @property string $slug
 * @property int $armorTypeId
 * @property int $armorClass
 * @property int $strengthPenalty
 * @property bool $stealthDisadvantage
 * @property float $weight
 * @property float $goldPrice
 */
final class Armor extends Item
{
    public const TYPE_LIGHT = 1;
    public const TYPE_MEDIUM = 2;
    public const TYPE_HEAVY = 3;
    public const TYPE_SHIELD = 4;
    
    public const SPECIFIC_FIELDS = [
        Field::ARMORTYPID,
        Field::ARMORCLASS,
        Field::STRPENALTY,
        Field::STHDISADV,
    ];
    public const SPECIFIC_FIELD_TYPES = [
        Field::ARMORTYPID => FieldType::INT,
        Field::ARMORCLASS => FieldType::INT,
        Field::STRPENALTY => FieldType::INT,
        Field::STHDISADV =>  FieldType::BOOL,
    ];
    public const FIELDS = [
        ...self::COMMON_FIELDS,
        ...self::SPECIFIC_FIELDS,
    ];
    public const FIELD_TYPES = [
        ...self::COMMON_FIELD_TYPES,
        ...self::SPECIFIC_FIELD_TYPES,
    ];
    /**
     * Retourne une représentation texte de l'armure
     */
    public function stringify(): string
    {
        return sprintf(
            "%s - CA: %s - Force malus: %s - Discrétion: %s - Poids: %s - Prix: %s",
            $this->name,
            $this->displayArmorClass(),
            $this->strengthPenalty ?: '-',
            $this->stealthDisadvantage ? 'Malus' : '-',
            $this->weight,
            $this->goldPrice
        );
    }

    public function displayArmorClass(): string
    {
        return match ($this->armorTypeId) {
            self::TYPE_SHIELD => '+' . $this->armorClass,
            self::TYPE_MEDIUM => $this->armorClass . ' + Dex (max 2)',
            self::TYPE_LIGHT => $this->armorClass . ' + Dex',
            self::TYPE_HEAVY => (string)$this->armorClass,
            default => (string)$this->armorClass,
        };
    }

    public function getSlug(): string
    {
        return $this->slug !== ''
            ? $this->slug
            : Utils::slugify($this->name);
    }
}
