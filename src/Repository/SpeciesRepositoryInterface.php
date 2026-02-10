<?php
namespace src\Repository;

use src\Domain\Entity\Specie;
use src\Collection\Collection;
use src\Domain\Criteria\SpeciesCriteria;

interface SpeciesRepositoryInterface
{
    /**
     * @return ?Specie
     */
    public function find(int $id): ?Specie;

    /**
     * @return Collection<Specie>
     */
    public function findAllWithCriteria(SpeciesCriteria $criteria, array $orderBy = []): Collection;
}
