<?php
namespace src\Entity;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgTypeAmmunition as RepositoryRpgTypeAmmunition;
use src\Repository\RpgWeaponProficiency as RepositoryRpgWeaponProficiency;

class RpgWeaponWeaponProficiency extends Entity
{

    public function __construct(
        protected int $id,
        protected int $weaponId,
        protected int $weaponProficiencyId,
        protected ?float $minRange,
        protected ?int $maxRange,
        protected ?int $typeAmmunitionId,
        protected ?string $versatileDamage
    ) {

    }

    public function getWeaponProficiency(): ?RpgWeaponProficiency
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgWeaponProficiency($queryBuilder, $queryExecutor);
        return $objDao->find($this->weaponProficiencyId);
    }

    public function getStrName(): string
    {
        $objWeaponProficiency = $this->getWeaponProficiency();
        $returned = $objWeaponProficiency->getField(Field::NAME);
        switch ($this->weaponProficiencyId) {
            case '1' :
                $objTypeAmmunition = $this->getTypeAmmunition();
                $returned .= ' (portée '.$this->minRange.'/'.$this->maxRange.' ; '.$objTypeAmmunition->getField(Field::NAME).')';
            break;
            case '8' :
                $returned .= ' (portée '.$this->minRange.'/'.$this->maxRange.')';
            break;
            case '10' :
                $returned .= ' ('.$this->versatileDamage.')';
            break;
            default :
            break;
        }
        return $returned;
    }
    
    public function getTypeAmmunition(): ?RpgTypeAmmunition
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RepositoryRpgTypeAmmunition($queryBuilder, $queryExecutor);
        return $objDao->find($this->typeAmmunitionId);
    }

}
