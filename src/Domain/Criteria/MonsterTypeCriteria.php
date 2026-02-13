<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class MonsterTypeCriteria extends BaseCriteria
{
    public ?string $abbr = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public array $orderBy = [
        Field::NAME => Constant::CST_ASC
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->abbr!=null) {
            $filters[Field::ABBR] = $this->abbr;
        }
        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, Field::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, Field::NAME, $this->nameGt);
    }
}
