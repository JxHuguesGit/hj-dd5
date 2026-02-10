<?php
namespace src\Repository;

use src\Domain\Weapon as DomainWeapon;
use src\Collection\Collection;
use src\Domain\Criteria\WeaponCriteria;

interface WeaponRepositoryInterface
{
    /**
     * @return DomainWeapon|null
     */
    public function find(int $id): ?DomainWeapon;

    /**
     * @return Collection<DomainWeapon>
     */
    public function findAllWithItemAndType(WeaponCriteria $criteria): Collection;
}
