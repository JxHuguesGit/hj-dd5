<?php
namespace src\Domain\Criteria;

use src\Constant\Field;
use src\Query\QueryBuilder;
use src\Repository\Repository;

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
        $this->applyEquals($queryBuilder, [
            Field::FEATID => $this->featId,
            Field::SLUG => $this->slug,
        ]);
        $this->applyLt($queryBuilder, Field::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, Field::NAME, $this->nameGt);
    }
}
