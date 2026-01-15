<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\Criteria\OriginCriteria;
use src\Domain\Origin as DomainOrigin;

class OriginRepository extends Repository implements OriginRepositoryInterface
{
    public const TABLE = Table::ORIGIN;
    
    public function getEntityClass(): string
    {
        return DomainOrigin::class;
    }

    /**
     * @return Collection<DomainOrigin>
     */
    public function findAllWithCriteria(
        OriginCriteria $criteria,
        array $orderBy = []
    ): Collection
    {
        return $this->findAllByCriteria($criteria, $orderBy);
    }

    public function find(int $id): DomainOrigin
    {
        return parent::find($id) ?? new DomainOrigin();
    }
}
