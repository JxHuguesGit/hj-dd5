<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Item as DomainItem;
use src\Domain\Criteria\ItemCriteria;
use src\Repository\ItemRepositoryInterface;

final class ItemReader
{
    public function __construct(
        private ItemRepositoryInterface $itemRepository
    ) {}

    public function itemById(int $id): ?DomainItem
    {
        return $this->itemRepository->find($id);
    }

    public function allGears(): Collection
    {
        return $this->itemRepository->findAllWithItemAndType(new ItemCriteria());
    }
}
