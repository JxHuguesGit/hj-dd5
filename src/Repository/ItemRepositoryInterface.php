<?php
namespace src\Repository;

use src\Domain\Entity\Item;
use src\Collection\Collection;
use src\Domain\Criteria\ItemCriteria;

interface ItemRepositoryInterface
{
    /**
     * @return ?Item
     */
    public function find(int $id): ?Item;

    /**
     * @return Collection<Item>
     */
    public function findAllWithRelations(ItemCriteria $criteria): Collection;
}
