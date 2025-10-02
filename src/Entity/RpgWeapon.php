<?php
namespace src\Entity;

use src\Collection\Collection;
use src\Constant\Field;
use src\Controller\RpgWeapon as ControllerRpgWeapon;
use src\Entity\RpgMasteryProficiency as EntityRpgMasteryProficiency;
use src\Entity\RpgTypeDamage as EntityRpgTypeDamage;
use src\Query\QueryBuilder;
use src\Query\QueryExecutor;
use src\Repository\RpgMasteryProficiency;
use src\Repository\RpgTypeDamage;
use src\Repository\RpgWeaponWeaponProficiency;

class RpgWeapon extends Entity
{

    public function __construct(
        protected int $id,
        protected string $name,
        protected string $damage,
        protected int $typeDamageId,
        protected float $weight,
        protected float $goldPrice,
        protected bool $martial,
        protected bool $melee,
        protected int $masteryProficiencyId
    ) {

    }

    public function getController(): ControllerRpgWeapon
    {
        $controller = new ControllerRpgWeapon;
        $controller->setField('rpgWeapon', $this);
        return $controller;
    }

    public function getMasteryProficiency(): ?EntityRpgMasteryProficiency
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgMasteryProficiency($queryBuilder, $queryExecutor);
        return $objDao->find($this->masteryProficiencyId);
    }

    public function getTypeDamage(): ?EntityRpgTypeDamage
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgTypeDamage($queryBuilder, $queryExecutor);
        return $objDao->find($this->typeDamageId);
    }

    public function getWeaponProficiencies(): Collection
    {
        $queryBuilder  = new QueryBuilder();
        $queryExecutor = new QueryExecutor();
        $objDao = new RpgWeaponWeaponProficiency($queryBuilder, $queryExecutor);
        return $objDao->findBy([Field::WEAPONID=>$this->id]);
    }

}