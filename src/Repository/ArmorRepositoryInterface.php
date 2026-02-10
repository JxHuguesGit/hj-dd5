<?php
namespace src\Repository;

use src\Domain\Entity\Armor;
use src\Collection\Collection;
use src\Domain\Criteria\ArmorCriteria;

interface ArmorRepositoryInterface
{
    /**
     * @return ?Armor
     */
    public function find(int $id): ?Armor;

    /**
     * @return Collection<Armor>
     */
    public function findAllWithItemAndType(ArmorCriteria $criteria): Collection;
}
