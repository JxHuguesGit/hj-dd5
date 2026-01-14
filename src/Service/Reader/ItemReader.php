<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Item as DomainItem;
use src\Repository\ItemRepositoryInterface;

final class ItemReader
{
    public function __construct(
        private ItemRepositoryInterface $itemRepository
    ) {}
    
    /**
     * @return Collection<DomainItem>
     */
    public function allItems(): Collection
    {
        $orderBy = [
            Field::NAME=>Constant::CST_ASC,
        ];
        return $this->itemRepository->findAll($orderBy);
    }

    public function itemById(int $id): ?DomainItem
    {
        return $this->itemRepository->find($id);
    }
}
