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
    public function findAllWithRelations(WeaponPropertyValueCriteria $criteria): Collection;
}
