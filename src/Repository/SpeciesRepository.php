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
        $filters = [];

        if ($criteria->slug !== null) {
            $filters[Field::SLUG] = $criteria->slug;
        }
        if ($criteria->nameLt !== null) {
            $this->queryBuilder->whereComplex([
                ['field' => Field::NAME, 'operand' => '<', 'value' => $criteria->nameLt]
            ]);
        }
        if ($criteria->nameGt !== null) {
            $this->queryBuilder->whereComplex([
                ['field' => Field::NAME, 'operand' => '>', 'value' => $criteria->nameGt]
            ]);
        }

        $this->query = $this->queryBuilder->reset()
            ->select($this->fields, $this->table)
            ->where($filters)
            ->orderBy($orderBy)
            ->getQuery();

        return $this->queryExecutor->fetchAll(
            $this->query,
            $this->resolveEntityClass(),
            $this->queryBuilder->getParams()
        );
    }
}
