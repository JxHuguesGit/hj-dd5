<?php
namespace src\Repository;

use src\Domain\Weapon as DomainWeapon;
use src\Collection\Collection;

interface WeaponRepositoryInterface
{
    public function find(int $id): ?DomainWeapon;
    public function findAll(array $orderBy = []): Collection;
}
