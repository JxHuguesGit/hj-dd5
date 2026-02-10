<?php
namespace src\Repository;

use src\Domain\Feat as DomainFeat;
use src\Collection\Collection;
use src\Domain\Criteria\FeatCriteria;

interface FeatRepositoryInterface
{
    /**
     * @return ?DomainFeat
     */
    public function find(int $id): ?DomainFeat;

    /**
     * @return Collection<DomainFeat>
     */
    public function findAllWithCriteria(FeatCriteria $criteria): Collection;
}
