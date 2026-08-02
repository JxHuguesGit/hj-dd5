<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\PowerCriteria;
use src\Domain\Entity\Power;

class PowerRepository extends Repository implements PowerRepositoryInterface
{
    public const TABLE = Table::POWER;

    public function getEntityClass(): string
    {
        return Power::class;
    }

    /**
     * @return ?Power
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Power
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Power>
     */
    public function findAllWithCriteria(PowerCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
