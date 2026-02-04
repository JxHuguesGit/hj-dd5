<?php
namespace src\Repository;

use src\Domain\Origin as DomainOrigin;
use src\Collection\Collection;
use src\Domain\Criteria\OriginCriteria;

interface OriginRepositoryInterface
{
    public function find(int $id): ?DomainOrigin;
    /**
     * @return Collection<DomainOrigin>
     */
    public function findAll(array $orderBy = []): Collection;
    /**
     * @return Collection<DomainOrigin>
     */
    public function findBy(array $criteria, array $orderBy = []): Collection;
    /**
     * @return Collection<DomainOrigin>
     */
    public function findByComplex(array $criteriaComplex, array $orderBy = [], int $limit = -1): Collection;
    /**
     * @return Collection<DomainOrigin>
     */
    public function findAllWithCriteria(OriginCriteria $criteria): Collection;
}
