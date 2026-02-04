<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\FeatCriteria;
use src\Domain\Feat as DomainFeat;

class FeatRepository extends Repository implements FeatRepositoryInterface
{
    public const TABLE = Table::FEAT;
    
    public function getEntityClass(): string
    {
        return DomainFeat::class;
    }

    /**
     * @return DomainFeat
     */
    public function find(int $id): DomainFeat
    {
        return parent::find($id) ?? new DomainFeat();
    }

    /**
     * @return Collection<DomainFeat>
     */
    public function findAllWithCriteria(
        FeatCriteria $criteria,
    ): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
