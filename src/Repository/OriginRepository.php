<?php
namespace src\Repository;

use src\Collection\Collection;
use src\Constant\Field;
use src\Constant\Table;
use src\Domain\Criteria\OriginCriteria;
use src\Domain\Origin as DomainOrigin;

class OriginRepository extends Repository implements OriginRepositoryInterface
{
    public const TABLE = Table::ORIGIN;
    
    public function getEntityClass(): string
    {
        return DomainOrigin::class;
    }

    /**
     * @return Collection<DomainOrigin>
     */
    public function findAllWithCriteria(
        OriginCriteria $criteria,
        array $orderBy = []
    ): Collection
    {
        $filters = [];

        if ($criteria->featId !== null) {
            $filters[Field::FEATID] = $criteria->featId;
        }
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
