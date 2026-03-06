<?php
namespace src\Domain\Criteria;

use src\Constant\Constant as C;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class SpeciesCriteria extends BaseCriteria
{
    public ?string $slug = null;
    public ?int $parentId = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public array $orderBy = [
        F::NAME => C::ASC
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        $filters[F::PARENTID] = $this->parentId;
        if ($this->slug!=null) {
            $filters[F::SLUG] = $this->slug;
        }

        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, F::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, F::NAME, $this->nameGt);
    }
}
