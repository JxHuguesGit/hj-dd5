<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\ReferenceCriteria;
use src\Domain\Entity\Reference;

interface ReferenceRepositoryInterface
{
    /**
     * @return ?Reference
     */
    public function find(int $id): ?Reference;

    /**
     * @return Collection<Reference>
     */
    public function findAllWithCriteria(ReferenceCriteria $criteria): Collection;
}
