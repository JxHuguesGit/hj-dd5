<?php
namespace src\Repository;

use src\Domain\Weapon as DomainWeapon;
use src\Collection\Collection;

interface WeaponRepositoryInterface
{
    public function find(int $id): ?DomainWeapon;
    /**
     * @return Collection<DomainWeapon>
     */
    public function findAll(array $orderBy = []): Collection;
    /**
     * @return Collection<DomainWeapon>
     */
    public function findByCategory(array $orderBy = []): Collection;
}
