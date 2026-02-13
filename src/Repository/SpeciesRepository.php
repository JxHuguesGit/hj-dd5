<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Table;
use src\Domain\Entity\Specie;
use src\Domain\Criteria\SpeciesCriteria;

class SpeciesRepository extends Repository implements SpeciesRepositoryInterface
{
    public const TABLE = Table::SPECIES;
    
    public function getEntityClass(): string
    {
        return Specie::class;
    }

    /**
     * @return Specie
     * @SuppressWarnings("php:S1185")
     */
    public function find(int $id): Specie
    {
        return parent::find($id);
    }

    /**
     * @return Collection<Specie>
     */
    public function findAllWithCriteria(SpeciesCriteria $criteria): Collection
    {
        return $this->findAllByCriteria($criteria);
    }
}
