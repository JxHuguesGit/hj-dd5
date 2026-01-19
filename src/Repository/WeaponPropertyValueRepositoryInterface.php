<?php
namespace src\Repository;

use src\Domain\WeaponPropertyValue as DomainWeaponPropertyValue;
use src\Collection\Collection;

interface WeaponPropertyValueRepositoryInterface
{
    public function find(int $id);
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
    public function byWeaponId(int $weaponId): Collection;
}
