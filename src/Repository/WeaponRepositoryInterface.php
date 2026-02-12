<?php
namespace src\Repository;

use src\Domain\Entity\Weapon;
use src\Collection\Collection;
use src\Domain\Criteria\WeaponCriteria;

interface WeaponRepositoryInterface
{
    /**
     * @return ?Weapon
     */
    public function find(int $id): ?Weapon;

    /**
     * @return Collection<Weapon>
     */
    public function findAllWithItemAndType(WeaponCriteria $criteria): Collection;
}
