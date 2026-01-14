<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Constant\Constant;
use src\Constant\Field;
use src\Domain\Item as DomainItem;
use src\Repository\Item as RepositoryItem;

final class ItemReader
{
    public function __construct(
        private RepositoryItem $itemRepository
    ) {}
    
    public function getAllItems(): Collection
    {
        $orderBy = [
            Field::NAME=>Constant::CST_ASC,
        ];
        return $this->itemRepository->findAll($orderBy);
    }

    public function getItem(int $id): ?DomainItem
    {
        return $this->itemRepository->find($id);
    }
}
