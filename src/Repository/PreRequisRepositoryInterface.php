<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\PreRequisCriteria;
use src\Domain\Entity\PreRequis;

interface PreRequisRepositoryInterface
{
    /**
     * @return ?PreRequis
     */
    public function find(int $id): ?PreRequis;

    /**
     * @return Collection<PreRequis>
     */
    public function findAllWithCriteria(PreRequisCriteria $criteria): Collection;
}
