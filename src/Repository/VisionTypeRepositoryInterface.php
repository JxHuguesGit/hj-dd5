<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\VisionTypeCriteria;
use src\Domain\Entity\VisionType;

interface VisionTypeRepositoryInterface
{
    /**
     * @return ?VisionType
     */
    public function find(int $id): ?VisionType;

    /**
     * @return Collection<VisionType>
     */
    public function findAllWithCriteria(VisionTypeCriteria $criteria): Collection;
}
