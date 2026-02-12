<?php
namespace src\Repository;

use src\Domain\Entity\Item;
use src\Collection\Collection;
use src\Domain\Criteria\ItemCriteria;

interface ItemRepositoryInterface
{
    /**
     * @return Collection<Item>
     */
    public function findAllWithItemAndType(ItemCriteria $criteria): Collection;

}
