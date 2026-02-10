<?php
namespace src\Repository;

use src\Domain\Item as DomainItem;
use src\Collection\Collection;
use src\Domain\Criteria\ItemCriteria;

interface ItemRepositoryInterface
{
    /**
     * @return ?DomainItem
     */
    public function find(int $id): ?DomainItem;

    /**
     * @return Collection<DomainItem>
     */
    public function findAllWithItemAndType(ItemCriteria $criteria): Collection;

}
