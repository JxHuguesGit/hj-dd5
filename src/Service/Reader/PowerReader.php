<?php

namespace src\Service\Reader;

use src\Collection\Collection;
use src\Domain\Criteria\PowerCriteria;
use src\Domain\Entity\Power;
use src\Repository\PowerRepositoryInterface;

final class PowerReader
{
    public function __construct(
        private PowerRepositoryInterface $powerRepository
    ) {}

    /**
     * @return ?Power
     */
    public function powerById(int $id): ?Power
    {
        return $this->powerRepository->find($id);
    }

    /**
     * @return Collection<Power>
     */
    public function powersByParentId(int $parentId): Collection
    {
        $criteria = new PowerCriteria();
        $criteria->parentId = $parentId;

        return $this->powerRepository->findAllWithCriteria($criteria);
    }
}
