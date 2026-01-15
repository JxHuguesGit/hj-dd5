<?php
namespace src\Domain\Criteria;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Repository\Repository;

final class OriginCriteria implements CriteriaInterface
{
    public ?int $featId = null;
    public ?string $type = null;
    public ?string $slug = null;
    public ?string $name = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];

        if ($this->featId !== null) {
            $filters[Field::FEATID] = $this->featId;
        }
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
