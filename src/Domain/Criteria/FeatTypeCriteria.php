<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class FeatTypeCriteria extends BaseCriteria
{
    public ?string $slug = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public array $orderBy = [
        F::NAME => Constant::ASC
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->slug!=null) {
            $filters[F::SLUG] = $this->slug;
        }
        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, F::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, F::NAME, $this->nameGt);
    }
}
