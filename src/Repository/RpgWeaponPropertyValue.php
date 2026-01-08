<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\RpgWeaponPropertyValue as DomainRpgWeaponPropertyValue;

class RpgWeaponPropertyValue extends Repository
{
    /*
    public const TABLE = Table::WPNPROPVALUE;

    public function getEntityClass(): string
    {
        return DomainRpgWeaponPropertyValue::class;
    }

    public function findByWeaponIds(array $weaponIds): Collection
    {
        $baseQuery = "
            SELECT wpv.id, ".Field::MINRANGE.", ".Field::MAXRANGE."
                , p.".Field::SLUG." AS ".Field::PROPERTYSLUG.", p.".Field::NAME." AS ".Field::PROPERTYNAME."
                , a.".Field::SLUG." AS ".Field::AMMOSLUG.", a.".Field::NAME." AS ".Field::AMMONAME."
            FROM " . Table::WPNPROPVALUE . " wpv
            INNER JOIN " . Table::WPNPROPERTY . " wp ON wp.id = wpv.".Field::WPNPROPID."
            LEFT JOIN " . Table::DMGDIE . " d ON d.id = a.".Field::DMGDIEID."
            LEFT JOIN " . Table::TYPEAMMO . " d ON d.id = a.".Field::TYPEAMMID."
        ";

        $this->query = $this->queryBuilder->reset()
            ->setBaseQuery($baseQuery)
//            ->where($criteria)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $this->queryBuilder->getParams(),
            true
        );
    }
        */
}
