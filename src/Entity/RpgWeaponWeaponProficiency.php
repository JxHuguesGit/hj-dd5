<?php
namespace src\Entity;

use src\Constant\Field;
use src\Repository\RpgTypeAmmunition as RepositoryRpgTypeAmmunition;
use src\Repository\RpgWeaponProficiency as RepositoryRpgWeaponProficiency;

class RpgWeaponWeaponProficiency extends Entity
{
    public const TABLE = 'rpgWeaponWeaponProficiency';
    public const FIELDS = [
        Field::ID,
        Field::WEAPONID,
        Field::WPNPROFID,
        Field::MINRANGE,
        Field::MAXRANGE,
        Field::TYPEAMMID,
        Field::POLYDMG,
    ];

    public const FIELD_TYPES = [
        Field::WEAPONID => 'intPositive',
        Field::WPNPROFID => 'intPositive',
        Field::MINRANGE => 'float',
        Field::MAXRANGE => 'intPositive',
        Field::TYPEAMMID => 'intPositive',
        Field::POLYDMG => 'string',
    ];
    
    protected int $weaponId = 0;
    protected int $weaponProficiencyId = 0;
    protected float $minRange = 0.0;
    protected int $maxRange = 0;
    protected int $typeAmmunitionId = 0;
    protected string $versatileDamage = '';

    private ?RpgWeaponProficiency $wpnProfCache = null;
    private ?RpgTypeAmmunition $ammoTypeCache = null;

    public function stringify(): string
    {
        return $this->getStrName();
    }

    public function getWeaponProficiency(): ?RpgWeaponProficiency
    {
        return $this->getRelatedEntity('wpnProfCache', RepositoryRpgWeaponProficiency::class, $this->weaponProficiencyId);
    }
    
    public function getTypeAmmunition(): ?RpgTypeAmmunition
    {
        return $this->getRelatedEntity('ammoTypeCache', RepositoryRpgTypeAmmunition::class, $this->typeAmmunitionId);
    }
    
    public function getStrName(): string
    {
        $objWeaponProficiency = $this->getWeaponProficiency();
        $returned = $objWeaponProficiency->getField(Field::NAME);
        switch ($this->weaponProficiencyId) {
            case 1 :
                $objTypeAmmunition = $this->getTypeAmmunition();
                $returned .= ' (portée '.$this->minRange.'/'.$this->maxRange.' ; '.$objTypeAmmunition->getField(Field::NAME).')';
            break;
            case 8 :
                $returned .= ' (portée '.$this->minRange.'/'.$this->maxRange.')';
            break;
            case 10 :
                $returned .= ' ('.$this->versatileDamage.')';
            break;
            default :
            break;
        }
        return $returned;
    }
}
