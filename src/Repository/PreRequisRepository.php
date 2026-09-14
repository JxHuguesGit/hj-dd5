<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\PreRequisCriteria;
use src\Domain\Entity\PreRequis;

class PreRequisRepository extends Repository implements PreRequisRepositoryInterface
{
    public const TABLE = Table::PREREQUIS;

    public function getEntityClass(): string
    {
        return PreRequis::class;
    }

    /**
     * @return ?PreRequis
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?PreRequis
    {
        return parent::find($id);
    }

    /**
     * @return Collection<PreRequis>
     */
    public function findAllWithCriteria(PreRequisCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
