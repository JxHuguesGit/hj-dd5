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
     * @return DomainOrigin
     */
    public function find(int $id): DomainOrigin
    {
        return parent::find($id) ?? new DomainOrigin();
    }

    /**
     * @return Collection<DomainOrigin>
     */
    public function findAllWithCriteria(
        OriginCriteria $criteria
    ): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
