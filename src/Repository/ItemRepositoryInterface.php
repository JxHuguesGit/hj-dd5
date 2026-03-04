<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\ItemCriteria;
use src\Domain\Entity\Item;

interface ItemRepositoryInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    /**
     * @return ?Item
     */
    public function find(int $id): ?Item;

    /**
     * @return Collection<Item>
     */
    public function findAllWithRelations(ItemCriteria $criteria): Collection;
}
