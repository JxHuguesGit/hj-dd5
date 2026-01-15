<?php
namespace src\Domain\Criteria;

use src\Constant\Field;
use src\Query\QueryBuilder;

final class OriginCriteria extends AbstractCriteria implements CriteriaInterface
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
        if ($this->featId!=null) {
            $filters[Field::FEATID] = $this->featId;
        }
        if ($this->slug!=null) {
            $filters[Field::SLUG] = $this->slug;
        }
        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, Field::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, Field::NAME, $this->nameGt);
    }
}
