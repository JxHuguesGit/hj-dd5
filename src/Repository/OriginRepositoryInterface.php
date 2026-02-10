<?php
namespace src\Repository;

use src\Domain\Origin as DomainOrigin;
use src\Collection\Collection;
use src\Domain\Criteria\OriginCriteria;

interface OriginRepositoryInterface
{
    /**
     * @return ?DomainOrigin
     */
    public function find(int $id): ?DomainOrigin;

    /**
     * @return Collection<DomainOrigin>
     */
    public function findAllWithCriteria(OriginCriteria $criteria): Collection;
}
