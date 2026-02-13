<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\FeatTypeCriteria;
use src\Domain\Entity\FeatType;

interface FeatTypeRepositoryInterface
{
    /**
     * @return ?FeatType
     */
    public function find(int $id): ?FeatType;

    /**
     * @return Collection<FeatType>
     */
    public function findAllWithCriteria(FeatTypeCriteria $criteria): Collection;
}
