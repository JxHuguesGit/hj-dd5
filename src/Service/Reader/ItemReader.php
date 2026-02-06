<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Item as DomainItem;
use src\Domain\Criteria\ItemCriteria;
use src\Repository\ItemRepositoryInterface;

final class ItemReader
{
    public function __construct(
        private ItemRepositoryInterface $itemRepository
    ) {}

    /**
     * @return ?DomainItem
     */
    public function itemById(int $id): ?DomainItem
    {
        return $this->itemRepository->find($id);
    }

    /**
     * @return ?DomainItem
     */
    public function itemBySlug(string $slug): ?DomainItem
    {
        $criteria = new ItemCriteria();
        $criteria->slug = $slug;
        return $this->itemRepository->findAllWithItemAndType($criteria)?->first() ?? null;
    }

    /**
     * @return Collection<DomainItem>
     */
    public function allGears(): Collection
    {
        return $this->itemRepository->findAllWithItemAndType(new ItemCriteria());
    }
}
