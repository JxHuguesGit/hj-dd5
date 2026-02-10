<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\OriginCriteria;
use src\Domain\Entity\Origin;

class OriginRepository extends Repository implements OriginRepositoryInterface
{
    public const TABLE = Table::ORIGIN;
    
    public function getEntityClass(): string
    {
        return Origin::class;
    }

    /**
     * @return Origin
     */
    public function find(int $id): Origin
    {
        return parent::find($id) ?? new Origin();
    }

    /**
     * @return Collection<Origin>
     */
    public function findAllWithCriteria(
        OriginCriteria $criteria
    ): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
