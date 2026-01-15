<?php
namespace src\Domain\Criteria;

use src\Constant\Field;
use src\Query\QueryBuilder;

final class SpeciesCriteria implements CriteriaInterface
{
    public ?string $slug = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];

        if ($this->slug !== null) {
            $filters[Field::SLUG] = $this->slug;
        }

        if ($filters) {
            $queryBuilder->where($filters);
        }

        if ($this->nameLt !== null) {
            $queryBuilder->whereComplex([
                ['field' => Field::NAME, 'operand' => '<', 'value' => $this->nameLt],
            ]);
        }

        if ($this->nameGt !== null) {
            $queryBuilder->whereComplex([
                ['field' => Field::NAME, 'operand' => '>', 'value' => $this->nameGt],
            ]);
        }
    }
}
