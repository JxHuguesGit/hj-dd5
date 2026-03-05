<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field as F;
use src\Query\QueryBuilder;

final class OriginCriteria extends BaseCriteria
{
    public ?int $featId = null;
    public ?int $toolId = null;
    public ?string $type = null;
    public ?string $slug = null;
    public ?string $name = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public array $orderBy = [
        F::NAME => Constant::ASC
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->featId!=null) {
            $filters[F::FEATID] = $this->featId;
        }
        if ($this->toolId!=null) {
            $filters[F::TOOLID] = $this->toolId;
        }
        if ($this->slug!=null) {
            $filters[F::SLUG] = $this->slug;
        }
        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, F::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, F::NAME, $this->nameGt);
    }
}
