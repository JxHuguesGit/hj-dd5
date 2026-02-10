<?php
namespace src\Repository;

use src\Domain\Armor as DomainArmor;
use src\Collection\Collection;
use src\Domain\Criteria\ArmorCriteria;

interface ArmorRepositoryInterface
{
    /**
     * @return ?DomainArmor
     */
    public function find(int $id): ?DomainArmor;

    /**
     * @return Collection<DomainArmor>
     */
    public function findAllWithItemAndType(ArmorCriteria $criteria): Collection;
}
