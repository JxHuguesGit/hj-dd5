<?php
namespace src\Service\Reader;

use src\Constant\Field as F;
use src\Collection\Collection;
use src\Domain\Entity\Item;
use src\Domain\Criteria\ItemCriteria;
use src\Repository\ItemRepositoryInterface;
use src\Utils\Navigation;

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
        return $this->itemRepository->findAllWithRelations($criteria)?->first() ?? null;
    }

    /**
     * @return Collection<Item>
     */
    public function allGears(): Collection
    {
        return $this->itemRepository->findAllWithRelations(new ItemCriteria());
    }

    public function getPreviousAndNext(Item $item): array
    {
        return Navigation::getPrevNext(
            function (string $operand, string $order) use ($item) {
                $criteria = new ItemCriteria();
                $operand === '&lt;'
                    ? $criteria->nameLt = $item->name
                    : $criteria->nameGt = $item->name
                ;
                $criteria->orderBy = [F::NAME => $order];
                return $this->itemRepository->findAllWithRelations($criteria);
            }
        );
    }
}
