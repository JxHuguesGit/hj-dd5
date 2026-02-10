<?php
namespace src\Repository;

use src\Domain\Entity\Feat;
use src\Collection\Collection;
use src\Domain\Criteria\FeatCriteria;

interface FeatRepositoryInterface
{
    /**
     * @return ?Feat
     */
    public function find(int $id): ?Feat;

    /**
     * @return Collection<DomainFeat>
     */
    public function findAllWithCriteria(FeatCriteria $criteria): Collection;
}
