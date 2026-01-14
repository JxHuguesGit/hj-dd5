<?php
namespace src\Repository;

use src\Domain\WeaponPropertyValue as DomainWeaponPropertyValue;
use src\Collection\Collection;

interface WeaponPropertyValueRepositoryInterface
{
    public function find(int $id): ?DomainWeaponPropertyValue;
    /**
     * @return Collection<DomainWeaponPropertyValue>
     */
    public function findAll(): Collection;
    /**
     * @return Collection<DomainWeaponPropertyValue>
     */
    public function byWeaponIds(array $weaponIds): Collection;
}
