<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Domain\Criteria\FeatPreRequisCriteria;
use src\Domain\Entity\FeatPreRequis;

interface FeatPreRequisRepositoryInterface
{
    public function beginTransaction(): void;
    public function commit(): void;
    public function rollBack(): void;

    public function insert(FeatPreRequis $featPreRequis): void;
    public function delete(FeatPreRequis $featPreRequis): void;

    /**
     * @return Collection<FeatPreRequis>
     */
    public function findAllWithCriteria(FeatPreRequisCriteria $criteria): Collection;
}
