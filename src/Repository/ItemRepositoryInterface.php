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


    public function insert(Item $item): void;
    public function delete(Item $item): void;
    public function updatePartial(Item $item, array $changedFields): void;

    /**
     * @return ?Item
     */
    public function find(int $id): ?Item;

    /**
     * @return Collection<Item>
     */
    public function findAllWithRelations(ItemCriteria $criteria): Collection;
}
