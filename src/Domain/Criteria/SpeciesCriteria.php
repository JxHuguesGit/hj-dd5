<?php
namespace src\Domain\Criteria;

use src\Constant\Field;
use src\Query\QueryBuilder;

final class SpeciesCriteria extends AbstractCriteria implements CriteriaInterface
{
    public ?string $slug = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public function apply(QueryBuilder $queryBuilder): void
    {
        $this->applyEquals($queryBuilder, [
            Field::SLUG => $this->slug,
        ]);
        $this->applyLt($queryBuilder, Field::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, Field::NAME, $this->nameGt);
    }
}
