<?php
namespace src\Domain\Criteria;

use src\Query\QueryBuilder;

abstract class AbstractCriteria implements CriteriaInterface
{
    protected function applyEquals(
        QueryBuilder $queryBuilder,
        array $filters
    ): void {
        if ($filters) {
            $queryBuilder->where($filters);
        }
    }

    protected function applyLt(
        QueryBuilder $queryBuilder,
        string $field,
        mixed $value
    ): void {
        if ($value !== null) {
            $queryBuilder->whereComplex([
                ['field' => $field, 'operand' => '<', 'value' => $value],
            ]);
        }
    }

    protected function applyGt(
        QueryBuilder $queryBuilder,
        string $field,
        mixed $value
    ): void {
        if ($value !== null) {
            $queryBuilder->whereComplex([
                ['field' => $field, 'operand' => '>', 'value' => $value],
            ]);
        }
    }

    protected function applyRange(
        QueryBuilder $qb,
        string $field,
        mixed $lt,
        mixed $gt
    ): void {
        $this->applyLt($qb, $field, $lt);
        $this->applyGt($qb, $field, $gt);
    }
}
