<?php
namespace src\Domain\Criteria;

use src\Constant\Constant;
use src\Constant\Field;
use src\Query\QueryBuilder;

final class AbilityCriteria extends BaseCriteria
{
    public ?string $name   = null;
    public ?string $nameLt = null;
    public ?string $nameGt = null;

    public array $orderBy = [
        Field::ID => Constant::CST_ASC,
    ];

    public function apply(QueryBuilder $queryBuilder): void
    {
        $filters = [];
        if ($this->name != null) {
            $filters[Field::NAME] = $this->name;
        }
        $this->applyEquals($queryBuilder, $filters);
        $this->applyLt($queryBuilder, Field::NAME, $this->nameLt);
        $this->applyGt($queryBuilder, Field::NAME, $this->nameGt);
    }
}
