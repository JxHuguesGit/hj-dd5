<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\DamageTypeCriteria;
use src\Domain\Entity\DamageType;

interface DamageTypeRepositoryInterface
{
    /**
     * @return ?DamageType
     */
    public function find(int $id): ?DamageType;

    /**
     * @return Collection<DamageType>
     */
    public function findAllWithCriteria(DamageTypeCriteria $criteria): Collection;
}
