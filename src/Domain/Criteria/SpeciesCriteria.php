<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class SpeciesCriteria extends BaseCriteria
{
    public ?string $slug = null;
    public ?int $parentId = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public array $orderBy = [
        Field::NAME => Constant::CST_ASC
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        $filters[Field::PARENTID] = $this->parentId;
        if ($this->slug!=null) {
            $filters[Field::SLUG] = $this->slug;
        }

        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, Field::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, Field::NAME, $this->nameGt);
    }
}
