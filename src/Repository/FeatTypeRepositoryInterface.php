<?php
namespace src\Repository;

use src\Domain\FeatType as DomainFeatType;
use src\Collection\Collection;
use src\Domain\Criteria\FeatTypeCriteria;

interface FeatTypeRepositoryInterface
{
    /**
     * @return Collection<DomainFeatType>
     */
    public function findAllWithCriteria(FeatTypeCriteria $criteria): Collection;
}
