<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\Specie as DomainSpecies;
use src\Domain\Criteria\SpeciesCriteria;

class SpeciesRepository extends Repository implements SpeciesRepositoryInterface
{
    public const TABLE = Table::SPECIES;
    
    public function getEntityClass(): string
    {
        return DomainSpecies::class;
    }

    /**
     * @return Collection<DomainOrigin>
     */
    public function findAllWithCriteria(
        SpeciesCriteria $criteria,
        array $orderBy = []
    ): Collection
    {
        return $this->findAllByCriteria($criteria, $orderBy);
    }

    public function find(int $id): DomainSpecies
    {
        return parent::find($id) ?? new DomainSpecies();
    }
}
