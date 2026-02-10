<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Criteria\FeatTypeCriteria;
use src\Domain\FeatType as DomainFeatType;

class FeatTypeRepository extends Repository implements FeatTypeRepositoryInterface
{
    public const TABLE = Table::FEATTYPE;

    public function getEntityClass(): string
    {
        return DomainFeatType::class;
    }

    /**
     * @return Collection<DomainFeatType>
     */
    public function findAllWithCriteria(
        FeatTypeCriteria $criteria
    ): Collection
    {
        return $this->findAllByCriteria($criteria);
    }

}
