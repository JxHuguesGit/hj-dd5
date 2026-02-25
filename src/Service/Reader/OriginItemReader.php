<?php
namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\OriginItemCriteria;
use src\Domain\Entity\OriginItem;
use src\Repository\OriginItemRepositoryInterface;

final class OriginItemReader
{
    public function __construct(
        private OriginItemRepositoryInterface $repository
    ) {}

    /**
     * @return ?OriginItem
     */
    public function originItemById(int $id): ?OriginItem
    {
        return $this->repository->find($id);
    }

    /**
     * @return Collection<OriginItem>
     */
    public function originItemsByItem(int $itemId): Collection
    {
        $criteria         = new OriginItemCriteria();
        $criteria->itemId = $itemId;
        return $this->repository->findAllWithCriteria($criteria);
    }

    /**
     * @return Collection<OriginItem>
     */
    public function originItemsByOrigin(int $originId): Collection
    {
        $criteria           = new OriginItemCriteria();
        $criteria->originId = $originId;
        return $this->repository->findAllWithCriteria($criteria);
    }
}
