<?php
namespace src\Repository;

use src\Domain\Criteria\SpeedTypeCriteria;
use src\Domain\Entity\SpeedType;
use src\Collection\Collection;

interface SpeedTypeRepositoryInterface
{
    /**
    * @return ?SpeedType
    */
    public function find(int $id): ?SpeedType;

    /**
     * @return Collection<SpeedType>
     */
    public function findAllWithCriteria(SpeedTypeCriteria $criteria): Collection;
}
