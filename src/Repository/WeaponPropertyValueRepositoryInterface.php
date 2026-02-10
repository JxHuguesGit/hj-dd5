<?php
namespace src\Repository;

use src\Domain\Entity\WeaponPropertyValue;
use src\Collection\Collection;
use src\Domain\Criteria\WeaponPropertyValueCriteria;

interface WeaponPropertyValueRepositoryInterface
{
    /**
     * @return ?WeaponPropertyValue
     */
    public function find(int $id): ?WeaponPropertyValue;

    /**
     * @return Collection<WeaponPropertyValue>
     */
    public function allWeaponPropertyValues(): Collection;

    /**
     * @return Collection<WeaponPropertyValue>
     */
    public function byWeaponIds(array $weaponIds): Collection;

    /**
     * @return Collection<WeaponPropertyValue>
     */
    public function findAllWithCriteria(WeaponPropertyValueCriteria $criteria): Collection;
}
