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
     * @return ?Origin
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Origin
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Origin>
     */
    public function findAllWithCriteria(OriginCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
