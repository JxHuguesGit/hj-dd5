<?php
namespace src\Repository;

use src\Domain\Specie as DomainSpecies;
use src\Collection\Collection;
use src\Domain\Criteria\SpeciesCriteria;

interface SpeciesRepositoryInterface
{
    public function find(int $id): ?DomainSpecies;
    /**
     * @return Collection<DomainSpecies>
     */
    public function findAll(array $orderBy = []): Collection;
    /**
     * @return Collection<DomainSpecies>
     */
    public function findBy(array $criteria, array $orderBy = []): Collection;
    /**
     * @return Collection<DomainSpecies>
     */
    public function findByComplex(array $criteriaComplex, array $orderBy = [], int $limit = -1): Collection;
    /**
     * @return Collection<DomainSpecies>
     */
    public function findAllWithCriteria(SpeciesCriteria $criteria, array $orderBy = []): Collection;
}
