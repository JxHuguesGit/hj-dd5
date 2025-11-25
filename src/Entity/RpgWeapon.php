<?php
namespace src\Entity;

use src\Collection\Collection;
use src\Constant\Field;
use src\Controller\RpgWeapon as ControllerRpgWeapon;
use src\Repository\RpgMasteryProficiency as RepositoryRpgMasteryProficiency;
use src\Repository\RpgTypeDamage as RepositoryRpgTypeDamage;
use src\Repository\RpgWeaponWeaponProficiency as RepositoryRpgWeaponWeaponProficiency;

class RpgWeapon extends Entity
{
    public const TABLE = 'rpgWeapon';
    public const FIELDS = [
        Field::ID,
        Field::NAME,
        Field::DAMAGE,
        Field::TYPEDMGID,
        Field::WEIGHT,
        Field::GOLDPRICE,
        Field::MARTIAL,
        Field::MELEE,
        Field::MSTPROFID,
    ];

    public const FIELD_TYPES = [
        Field::NAME => 'string',
        Field::DAMAGE => 'string',
        Field::TYPEDMGID => 'intPositive',
        Field::WEIGHT => 'float',
        Field::GOLDPRICE => 'float',
        Field::MARTIAL => 'bool',
        Field::MELEE => 'bool',
        Field::MSTPROFID => 'intPositive',
    ];
    
    protected string $name = '';
    protected string $damage = '';
    protected int $typeDamageId = 0;
    protected float $weight = 0.0;
    protected float $goldPrice = 0.0;
    protected bool $martial = false;
    protected bool $melee = false;
    protected int $masteryProficiencyId = 0;

    private ?RpgMasteryProficiency $masteryProficiencyCache = null;
    private ?RpgTypeDamage $typeDamageCache = null;
    private ?Collection $weaponWeaponProficiencysCache = null;
    
    // TODO : à externaliser
    public function getController(): ControllerRpgWeapon
    {
        $controller = new ControllerRpgWeapon;
        $controller->setField(self::TABLE, $this);
        return $controller;
    }

    public function stringify(): string
    {
        return sprintf(
            "%s (%s) - %.2f kg - %.2f gp",
            $this->getName(),
            $this->getDamage(),
            $this->getWeight(),
            $this->getGoldPrice()
        );
    }

    public function getMasteryProficiency(): ?RpgMasteryProficiency
    {
        return $this->getRelatedEntity('masteryProficiencyCache', RepositoryRpgMasteryProficiency::class, $this->masteryProficiencyId);
    }

    public function getTypeDamage(): ?RpgTypeDamage
    {
        return $this->getRelatedEntity('typeDamageCache', RepositoryRpgTypeDamage::class, $this->typeDamageId);
    }

    public function getWeaponProficiencies(): Collection
    {
        if ($this->weaponWeaponProficiencysCache === null) {
            $objDao = new RepositoryRpgWeaponWeaponProficiency(static::$qb, static::$qe);
            $this->weaponWeaponProficiencysCache = $objDao->findBy([Field::WEAPONID=>$this->getId()], [Field::NAME=>'ASC']);
        }
        return $this->weaponWeaponProficiencysCache;
    }
}
