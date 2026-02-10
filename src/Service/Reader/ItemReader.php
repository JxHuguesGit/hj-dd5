<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Entity\Item;
use src\Domain\Criteria\ItemCriteria;
use src\Repository\ItemRepositoryInterface;

final class ItemReader
{
    public function __construct(
        private ItemRepositoryInterface $itemRepository
    ) {}

    /**
     * @return ?Item
     */
    public function itemById(int $id): ?Item
    {
        return $this->itemRepository->find($id);
    }

    /**
     * @return ?Item
     */
    public function itemBySlug(string $slug, ?ItemCriteria $criteria): ?Item
    {
        if ($criteria==null) {
            $criteria = new ItemCriteria();
        }
        $criteria->slug = $slug;
        return $this->itemRepository->findAllWithItemAndType($criteria)?->first() ?? null;
    }

    /**
     * @return Collection<Item>
     */
    public function allGears(): Collection
    {
        return $this->itemRepository->findAllWithItemAndType(new ItemCriteria());
    }
}
