<?php
namespace src\Repository;

use src\Domain\WeaponPropertyValue as DomainWeaponPropertyValue;
use src\Collection\Collection;
use src\Domain\Criteria\WeaponPropertyValueCriteria;

interface WeaponPropertyValueRepositoryInterface
{
    /**
     * @return ?DomainWeaponPropertyValue
     */
    public function find(int $id): ?DomainWeaponPropertyValue;

    /**
     * @return Collection<DomainWeaponPropertyValue>
     */
    public function allWeaponPropertyValues(): Collection;

    /**
     * @return Collection<DomainWeaponPropertyValue>
     */
    public function byWeaponIds(array $weaponIds): Collection;

    /**
     * @return Collection<DomainWeaponPropertyValue>
     */
    public function findAllWithCriteria(WeaponPropertyValueCriteria $criteria): Collection;
}
