<?php
namespace src\Repository;

use src\Domain\Entity\Origin;
use src\Collection\Collection;
use src\Domain\Criteria\OriginCriteria;

interface OriginRepositoryInterface
{
    /**
     * @return ?Origin
     */
    public function find(int $id): ?Origin;

    /**
     * @return Collection<Origin>
     */
    public function findAllWithCriteria(OriginCriteria $criteria): Collection;
}
