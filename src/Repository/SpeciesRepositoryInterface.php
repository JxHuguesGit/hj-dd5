<?php
namespace src\Repository;

use src\Domain\Specie as DomainSpecies;
use src\Collection\Collection;
use src\Domain\Criteria\SpeciesCriteria;

interface SpeciesRepositoryInterface
{
    /**
     * @return ?DomainSpecies
     */
    public function find(int $id): ?DomainSpecies;

    /**
     * @return Collection<DomainSpecies>
     */
    public function findAllWithCriteria(SpeciesCriteria $criteria, array $orderBy = []): Collection;
}
