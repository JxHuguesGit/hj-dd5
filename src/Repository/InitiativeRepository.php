<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\InitiativeCriteria;
use src\Domain\Entity\Initiative;

class InitiativeRepository extends Repository implements InitiativeRepositoryInterface
{
    public const TABLE = Table::INITIATIVE;
    
    public function getEntityClass(): string
    {
        return Initiative::class;
    }

    /**
     * @return ?Initiative
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): ?Initiative
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Initiative>
     */
    public function findAllWithCriteria(InitiativeCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
